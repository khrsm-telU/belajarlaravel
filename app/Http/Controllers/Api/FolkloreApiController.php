<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FolkloreStory;
use App\Models\StoryScore;
use Database\Seeders\FolkloreSeeder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FolkloreApiController extends Controller
{
    /**
     * Helper untuk mengembalikan JSON yang selalu rapi (Pretty Print) di Postman, Browser, & Unity.
     */
    private function prettyJson(mixed $data, int $status = 200): JsonResponse
    {
        return response()->json(
            $data,
            $status,
            ['Content-Type' => 'application/json; charset=UTF-8'],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * Pastikan data folklore Indonesia sudah terisi di database.
     */
    private function ensureSeeded(): void
    {
        if (FolkloreStory::count() === 0) {
            (new FolkloreSeeder())->run();
        }
    }

    /**
     * Modul 7: GET Daftar Cerita Folklore Indonesia (StoryListResponse & StoryDto[])
     */
    public function index(Request $request)
    {
        $this->ensureSeeded();

        $stories = FolkloreStory::orderBy('id', 'asc')->get()->map(function (FolkloreStory $item) {
            return [
                'id'         => $item->id,
                'title'      => $item->title,
                'synopsis'   => $item->synopsis,
                'origin'     => $item->origin_region,
                'markerCode' => $item->marker_code,
                'maxPoints'  => (int) $item->max_points,
            ];
        })->values();

        if ($request->boolean('raw')) {
            return $this->prettyJson($stories, 200);
        }

        return $this->prettyJson([
            'status' => 'ok',
            'data'   => $stories,
        ], 200);
    }

    /**
     * GET Detail 1 cerita Folklore Indonesia berdasarkan ID (contoh: /api/stories/story_001)
     */
    public function show(string $id)
    {
        $this->ensureSeeded();

        $item = FolkloreStory::find($id);
        if (!$item) {
            return $this->prettyJson([
                'status'  => 'error',
                'message' => "Cerita dengan id '{$id}' tidak ditemukan.",
            ], 404);
        }

        return $this->prettyJson([
            'status' => 'ok',
            'data'   => [
                'id'         => $item->id,
                'title'      => $item->title,
                'synopsis'   => $item->synopsis,
                'origin'     => $item->origin_region,
                'markerCode' => $item->marker_code,
                'maxPoints'  => (int) $item->max_points,
            ],
        ], 200);
    }

    /**
     * Modul 8: POST Trigger Pengiriman Poin (ScoreSubmission -> ScoreResponse)
     */
    public function submitScore(Request $request)
    {
        $this->ensureSeeded();

        // 1. Cek Content-Type: tolak form-urlencoded (jebakan overload UnityWebRequest.Post(url, string) pada Modul 8)
        $contentType = (string) $request->header('Content-Type', '');
        if (stripos($contentType, 'application/json') === false && !$request->isJson()) {
            return $this->prettyJson([
                'status'      => 'error',
                'message'     => 'Header Content-Type harus application/json (gunakan UploadHandlerRaw, bukan overload Post form-urlencoded).',
                'totalPoints' => 0,
                'rank'        => 0,
            ], 415);
        }

        $payload = $request->json()->all();
        if (empty($payload)) {
            $decoded = json_decode($request->getContent(), true);
            $payload = is_array($decoded) ? $decoded : [];
        }

        $sessionId           = trim((string) ($payload['sessionId'] ?? ''));
        $playerName          = trim((string) ($payload['playerName'] ?? ''));
        $storyId             = trim((string) ($payload['storyId'] ?? ''));
        $points              = isset($payload['points']) ? (int) $payload['points'] : null;
        $objectivesCompleted = isset($payload['objectivesCompleted']) ? (int) $payload['objectivesCompleted'] : 0;
        $durationSeconds     = isset($payload['durationSeconds']) ? (int) $payload['durationSeconds'] : 0;

        // 2. Validasi field wajib (Modul 8 Tugas 8.2: jika storyId / sessionId / playerName kosong -> 400 Bad Request)
        if ($sessionId === '' || $playerName === '' || $storyId === '' || $points === null || $points < 0) {
            return $this->prettyJson([
                'status'      => 'error',
                'message'     => 'Field wajib (sessionId, playerName, storyId, points) tidak lengkap atau tidak valid.',
                'totalPoints' => 0,
                'rank'        => 0,
            ], 400);
        }

        // 3. Pengaman ganda-kirim sisi server (Idempotensi berdasarkan sessionId unik - Modul 8 Hal. 3)
        $existing = StoryScore::where('session_id', $sessionId)->first();
        if ($existing) {
            [$totalPoints, $rank] = $this->calculatePlayerStats($existing->player_name);

            return $this->prettyJson([
                'status'      => 'ok',
                'message'     => 'Sesi ini sudah pernah tercatat sebelumnya (pengaman duplikat aktif, poin tidak dihitung ganda)',
                'totalPoints' => $totalPoints,
                'rank'        => $rank,
            ], 200);
        }

        // 4. Simpan skor baru
        StoryScore::create([
            'session_id'           => $sessionId,
            'player_name'          => $playerName,
            'story_id'             => $storyId,
            'points'               => $points,
            'objectives_completed' => max(0, $objectivesCompleted),
            'duration_seconds'     => max(0, $durationSeconds),
        ]);

        [$totalPoints, $rank] = $this->calculatePlayerStats($playerName);

        return $this->prettyJson([
            'status'      => 'ok',
            'message'     => 'Skor tersimpan',
            'totalPoints' => $totalPoints,
            'rank'        => $rank,
        ], 200);
    }

    /**
     * GET Leaderboard / Riwayat Skor (/api/scores atau /api/leaderboard)
     */
    public function leaderboard()
    {
        $rankings = StoryScore::select('player_name', DB::raw('SUM(points) as total_points'), DB::raw('COUNT(*) as sessions_played'))
            ->groupBy('player_name')
            ->orderByDesc('total_points')
            ->get()
            ->values()
            ->map(function ($row, $index) {
                return [
                    'rank'           => $index + 1,
                    'playerName'     => $row->player_name,
                    'totalPoints'    => (int) $row->total_points,
                    'sessionsPlayed' => (int) $row->sessions_played,
                ];
            });

        return $this->prettyJson([
            'status'      => 'ok',
            'leaderboard' => $rankings,
        ], 200);
    }

    /**
     * Modul 7 Langkah 6.3: Endpoint simulasi delay untuk menguji timeoutSeconds di Unity (/api/delay/{seconds})
     */
    public function delay(int $seconds = 10)
    {
        $wait = max(1, min($seconds, 15));
        sleep($wait);

        return $this->index(request());
    }

    /**
     * Hitung total poin akumulasi pemain dan peringkat (rank) di antara seluruh pemain.
     */
    private function calculatePlayerStats(string $playerName): array
    {
        $totals = StoryScore::select('player_name', DB::raw('SUM(points) as total_points'))
            ->groupBy('player_name')
            ->orderByDesc('total_points')
            ->get();

        $playerTotal = 0;
        $rank = 1;
        foreach ($totals as $idx => $row) {
            if (strcasecmp($row->player_name, $playerName) === 0) {
                $playerTotal = (int) $row->total_points;
                $rank = $idx + 1;
                break;
            }
        }

        return [$playerTotal, $rank];
    }
}
