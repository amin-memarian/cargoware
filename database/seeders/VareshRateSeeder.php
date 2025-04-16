<?php

namespace Database\Seeders;

use App\Models\VareshRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VareshRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            [
                'destination' => 'BUS',
                'minimum' => '20000000',
                'normal' => '2000000',
            ],
            [
                'destination' => 'TBS',
                'minimum' => '20000000',
                'normal' => '2000000',
            ],
            [
                'destination' => 'DYU',
                'minimum' => '20000000',
                'normal' => '2000000',
            ],
            [
                'destination' => 'EVN',
                'minimum' => '25000000',
                'normal' => '2500000',
            ],
            [
                'destination' => 'MCT',
                'minimum' => '30000000',
                'normal' => '3000000',
            ],
            [
                'destination' => 'DOH',
                'minimum' => '40000000',
                'normal' => '4000000',
            ]
        ];

        foreach ($rows as $row) {
            VareshRate::create($row);
        }
    }
}
