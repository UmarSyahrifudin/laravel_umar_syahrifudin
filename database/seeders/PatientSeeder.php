<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patients = [
            [
                'name' => 'Pasien A',
                'address' => 'Jl. Melati No.1',
                'phone' => '081234567890',
                'hospital_id' => 1
            ],
            [
                'name' => 'Pasien B',
                'address' => 'Jl. Mawar No.2',
                'phone' => '081345678901',
                'hospital_id' => 1
            ],
            [
                'name' => 'Pasien C',
                'address' => 'Jl. Anggrek No.3',
                'phone' => '081456789012',
                'hospital_id' => 2
            ],
            [
                'name' => 'Pasien D',
                'address' => 'Jl. Dahlia No.4',
                'phone' => '081567890123',
                'hospital_id' => 2
            ],
            [
                'name' => 'Pasien E',
                'address' => 'Jl. Kenanga No.5',
                'phone' => '081678901234',
                'hospital_id' => 3
            ],
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }
    }
}
