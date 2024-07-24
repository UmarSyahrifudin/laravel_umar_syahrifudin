<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hospital;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hospitals = [
            [
                'name' => 'Rumah Sakit Umum A',
                'address' => 'Jl. Kebon Jeruk No.1',
                'email' => 'rsu_a@example.com',
                'phone' => '0211234567'
            ],
            [
                'name' => 'Rumah Sakit Umum B',
                'address' => 'Jl. Sudirman No.2',
                'email' => 'rsu_b@example.com',
                'phone' => '0212345678'
            ],
            [
                'name' => 'Rumah Sakit Umum C',
                'address' => 'Jl. Thamrin No.3',
                'email' => 'rsu_c@example.com',
                'phone' => '0213456789'
            ]
        ];

        foreach ($hospitals as $hospital) {
            Hospital::create($hospital);
        }
    }
}
