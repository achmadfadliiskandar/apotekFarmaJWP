<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaftarObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel terlebih dahulu agar tidak duplikat saat di-seed ulang
        DB::table('daftar_obats')->truncate();

        DB::table('daftar_obats')->insert([
            [
                'id' => 1,
                'kode_obat' => 'OBT-0001',
                'nama_obat' => 'Cefadroxil 500mg',
                'satuan' => 'Kapsul',
                'stok' => 120,
                'kategori_id' => 1, // Antibiotik
                'user_id' => 1,
                // 'foto' => 'obat/1717900001_cefadroxil.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'kode_obat' => 'OBT-0002',
                'nama_obat' => 'Sanmol 500mg',
                'satuan' => 'Tablet',
                'stok' => 300,
                'kategori_id' => 2, // Analgesik & Antipiretik
                'user_id' => 1,
                // 'foto' => 'obat/1717900002_sanmol.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'kode_obat' => 'OBT-0003',
                'nama_obat' => 'Alleron',
                'satuan' => 'Kaplet',
                'stok' => 150,
                'kategori_id' => 3, // Antihistamin
                'user_id' => 1,
                // 'foto' => 'obat/1717900003_alleron.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'kode_obat' => 'OBT-0004',
                'nama_obat' => 'Erythromycin 500mg',
                'satuan' => 'Tablet',
                'stok' => 80,
                'kategori_id' => 1, // Antibiotik
                'user_id' => 1,
                // 'foto' => 'obat/1717900004_erythromycin.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'kode_obat' => 'OBT-0005',
                'nama_obat' => 'Panadol Extra',
                'satuan' => 'Strip',
                'stok' => 200,
                'kategori_id' => 2, // Analgesik & Antipiretik
                'user_id' => 1,
                // 'foto' => 'obat/1717900005_panadol_extra.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'kode_obat' => 'OBT-0006',
                'nama_obat' => 'Incidal-OD',
                'satuan' => 'Kapsul',
                'stok' => 75,
                'kategori_id' => 3, // Antihistamin
                'user_id' => 2,
                // 'foto' => 'obat/1717900006_incidal.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'kode_obat' => 'OBT-0007',
                'nama_obat' => 'Ibuprofen 400mg',
                'satuan' => 'Tablet',
                'stok' => 180,
                'kategori_id' => 2, // Analgesik & Antipiretik
                'user_id' => 2,
                // 'foto' => 'obat/1717900007_ibuprofen.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'kode_obat' => 'OBT-0008',
                'nama_obat' => 'Clindamycin 300mg',
                'satuan' => 'Kapsul',
                'stok' => 90,
                'kategori_id' => 1, // Antibiotik
                'user_id' => 2,
                // 'foto' => 'obat/1717900008_clindamycin.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'kode_obat' => 'OBT-0009',
                'nama_obat' => 'Omedom 10mg',
                'satuan' => 'Tablet',
                'stok' => 100,
                'kategori_id' => 3, // Antihistamin
                'user_id' => 2,
                // 'foto' => 'obat/1717900009_omedom.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'kode_obat' => 'OBT-0010',
                'nama_obat' => 'Asam Mefenamat 500mg',
                'satuan' => 'Kaplet',
                'stok' => 220,
                'kategori_id' => 2, // Analgesik & Antipiretik
                // 'foto' => 'obat/1717900010_asan_mefenamat.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
