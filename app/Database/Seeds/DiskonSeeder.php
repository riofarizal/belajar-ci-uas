<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        
        // Menggunakan tanggal hari ini
        $startDate = date('Y-m-d'); // Current date
        
        // Generate 10 data diskon untuk tanggal hari ini dan 9 hari selanjutnya
        for ($i = 0; $i < 10; $i++) {
            $currentDate = date('Y-m-d', strtotime($startDate . ' +' . $i . ' days'));
            
            // Cek apakah tanggal sudah ada di database
            $existing = $this->db->table('diskon')
                                ->where('tanggal', $currentDate)
                                ->countAllResults();
            
            // Jika tanggal belum ada, tambahkan ke array data
            if ($existing == 0) {
                $data[] = [
                    'tanggal'    => $currentDate,
                    'nominal'    => rand(50000, 500000), // Random discount antara 50k-500k
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            } else {
                echo "Data untuk tanggal {$currentDate} sudah ada, dilewati.\n";
            }
        }

        // Insert data ke table diskon jika ada data yang perlu diinsert
        if (!empty($data)) {
            $this->db->table('diskon')->insertBatch($data);
            echo "Seeder berhasil menambahkan " . count($data) . " data diskon baru.\n";
        } else {
            echo "Tidak ada data baru yang perlu ditambahkan.\n";
        }
    }
}