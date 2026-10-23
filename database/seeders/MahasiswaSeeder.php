<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mahasiswas')->insert([
            [
                'nim'     => '1234567890',
                'nama'    => 'Rahmat Adi Saputra',
                'jk'      => 'L',
                'prodi'   => 'Sistem Informasi',
                'no_telp' => '081234567890',
                'alamat'  => 'Jl. Merdeka No.1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
