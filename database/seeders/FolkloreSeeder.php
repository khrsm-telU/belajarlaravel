<?php

namespace Database\Seeders;

use App\Models\FolkloreStory;
use Illuminate\Database\Seeder;

class FolkloreSeeder extends Seeder
{
    public static function defaultStories(): array
    {
        return [
            [
                'id'            => 'story_001',
                'title'         => 'Legenda Situ Bagendit',
                'synopsis'      => 'Kisah rakyat dari Jawa Barat tentang Nyai Bagendit yang kikir terhadap warga desa hingga muncul mata air besar yang menenggelamkan seluruh hartanya menjadi danau.',
                'origin_region' => 'Jawa Barat',
                'marker_code'   => 'MRK-001',
                'max_points'    => 100,
            ],
            [
                'id'            => 'story_002',
                'title'         => 'Malin Kundang',
                'synopsis'      => 'Cerita rakyat dari Sumatera Barat tentang seorang pemuda perantau yang sukses menjadi saudagar kaya namun mengingkari ibu kandungnya hingga dikutuk menjadi batu di Pantai Air Manis.',
                'origin_region' => 'Sumatera Barat',
                'marker_code'   => 'MRK-002',
                'max_points'    => 100,
            ],
            [
                'id'            => 'story_003',
                'title'         => 'Roro Jonggrang & Candi Prambanan',
                'synopsis'      => 'Legenda dari DI Yogyakarta dan Jawa Tengah mengenai syarat pembangunan seribu candi dalam satu malam oleh Bandung Bondowoso dan asal-usul Candi Sewu serta arca Roro Jonggrang.',
                'origin_region' => 'DI Yogyakarta & Jawa Tengah',
                'marker_code'   => 'MRK-003',
                'max_points'    => 120,
            ],
            [
                'id'            => 'story_004',
                'title'         => 'Sangkuriang (Tangkuban Perahu)',
                'synopsis'      => 'Kisah legenda Pasundan tentang Sangkuriang yang membendung Sungai Citarum dan membuat perahu besar demi meminang Dayang Sumbi, hingga perahu yang ditendangnya terbalik menjadi Gunung Tangkuban Perahu.',
                'origin_region' => 'Jawa Barat',
                'marker_code'   => 'MRK-004',
                'max_points'    => 110,
            ],
            [
                'id'            => 'story_005',
                'title'         => 'Timun Mas dan Buto Ijo',
                'synopsis'      => 'Dongeng rakyat Jawa Tengah tentang gadis pemberani yang lahir dari buah mentimun emas dan berhasil menyelamatkan diri dari kejaran raksasa Buto Ijo menggunakan biji mentimun, jarum, garam, dan terasi ajaib.',
                'origin_region' => 'Jawa Tengah',
                'marker_code'   => 'MRK-005',
                'max_points'    => 100,
            ],
            [
                'id'            => 'story_006',
                'title'         => 'Asal-usul Danau Toba',
                'synopsis'      => 'Legenda dari Sumatera Utara tentang petani bernama Toba yang menikahi putri jelmaan ikan mas dengan janji merahasiakan asal-usulnya, hingga pelanggaran janji itu melahirkan Danau Toba dan Pulau Samosir.',
                'origin_region' => 'Sumatera Utara',
                'marker_code'   => 'MRK-006',
                'max_points'    => 100,
            ],
            [
                'id'            => 'story_007',
                'title'         => 'Lutung Kasarung dan Purbasari',
                'synopsis'      => 'Kisah pantun Sunda tentang Putri Purbasari yang diasingkan ke hutan oleh kakaknya Purbararang dan ditolong oleh Lutung Kasarung yang merupakan jelmaan Pangeran Guruminda dari Kahyangan.',
                'origin_region' => 'Jawa Barat',
                'marker_code'   => 'MRK-007',
                'max_points'    => 90,
            ],
            [
                'id'            => 'story_008',
                'title'         => 'Bawang Merah dan Bawang Putih',
                'synopsis'      => 'Cerita rakyat Nusantara tentang dua saudari tiri dengan sifat bertolak belakang; ketulusan Bawang Putih berbuah labu berisi perhiasan, sementara keserakahan Bawang Merah membawa petaka.',
                'origin_region' => 'Riau & Jawa',
                'marker_code'   => 'MRK-008',
                'max_points'    => 80,
            ],
            [
                'id'            => 'story_009',
                'title'         => 'Keong Mas (Candra Kirana)',
                'synopsis'      => 'Kisah Panji dari Jawa Timur tentang Putri Candra Kirana dari Kerajaan Daha yang disihir menjadi keong emas lalu dirawat oleh Mbok Rondo Dadapan hingga bertemu kembali dengan Raden Inu Kertapati.',
                'origin_region' => 'Jawa Timur',
                'marker_code'   => 'MRK-009',
                'max_points'    => 90,
            ],
            [
                'id'            => 'story_010',
                'title'         => 'Legenda Batu Menangis',
                'synopsis'      => 'Cerita rakyat dari Kalimantan Barat tentang seorang gadis berwajah jelita bernama Darmi yang malu mengakui ibunya yang miskin hingga perlahan-lahan tubuhnya membatu sambil meneteskan air mata.',
                'origin_region' => 'Kalimantan Barat',
                'marker_code'   => 'MRK-010',
                'max_points'    => 85,
            ],
        ];
    }

    public function run(): void
    {
        foreach (self::defaultStories() as $item) {
            FolkloreStory::updateOrCreate(
                ['id' => $item['id']],
                $item
            );
        }
    }
}
