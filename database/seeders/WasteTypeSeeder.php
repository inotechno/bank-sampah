<?php

namespace Database\Seeders;

use App\Models\WasteType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WasteTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Kertas',
                'description' => 'Termasuk koran bekas, majalah, kardus, dan kertas dokumen.',
                'price_per_kg' => 2500,
            ],
            [
                'name' => 'Plastik',
                'description' => 'Botol PET, kantong plastik, dan plastik kemasan rumah tangga lainnya.',
                'price_per_kg' => 3500,
            ],
            [
                'name' => 'Logam',
                'description' => 'Meliputi besi, aluminium, kaleng minuman, dan logam bekas lainnya.',
                'price_per_kg' => 5500,
            ],
            [
                'name' => 'Kaca',
                'description' => 'Botol kaca, pecahan kaca, dan kaca rumah tangga yang dapat didaur ulang.',
                'price_per_kg' => 2000,
            ],
            [
                'name' => 'Tekstil',
                'description' => 'Pakaian bekas, kain, dan tekstil rumah tangga yang masih dapat dimanfaatkan.',
                'price_per_kg' => 1800,
            ],
            [
                'name' => 'Elektronik',
                'description' => 'Perangkat elektronik kecil seperti ponsel, charger, kabel, dan sejenisnya.',
                'price_per_kg' => 12000,
            ],
            [
                'name' => 'Minyak Jelantah',
                'description' => 'Minyak goreng bekas pakai yang telah disaring dari kotoran.',
                'price_per_kg' => 7000,
            ],
        ];

        foreach ($types as $type) {
            WasteType::updateOrCreate(
                ['slug' => Str::slug($type['name'])],
                [
                    'name' => $type['name'],
                    'description' => $type['description'],
                    'price_per_kg' => $type['price_per_kg'],
                    'is_active' => true,
                ]
            );
        }
    }
}
