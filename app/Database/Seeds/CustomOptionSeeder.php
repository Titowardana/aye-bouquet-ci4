<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class CustomOptionSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->format('Y-m-d H:i:s');
        
        $data = [
            // Sizes
            ['type' => 'size', 'name' => 'S', 'additional_price' => 0, 'sort_order' => 1],
            ['type' => 'size', 'name' => 'M', 'additional_price' => 0, 'sort_order' => 2],
            ['type' => 'size', 'name' => 'L', 'additional_price' => 0, 'sort_order' => 3],
            ['type' => 'size', 'name' => 'XL', 'additional_price' => 0, 'sort_order' => 4],
            ['type' => 'size', 'name' => 'XXL', 'additional_price' => 0, 'sort_order' => 5],
            ['type' => 'size', 'name' => 'Jumbo', 'additional_price' => 0, 'sort_order' => 6],
            
            // Colors
            ['type' => 'color', 'name' => 'Pink', 'additional_price' => 0, 'sort_order' => 1],
            ['type' => 'color', 'name' => 'Merah', 'additional_price' => 0, 'sort_order' => 2],
            ['type' => 'color', 'name' => 'Putih', 'additional_price' => 0, 'sort_order' => 3],
            ['type' => 'color', 'name' => 'Biru', 'additional_price' => 0, 'sort_order' => 4],
            ['type' => 'color', 'name' => 'Ungu', 'additional_price' => 0, 'sort_order' => 5],
            ['type' => 'color', 'name' => 'Gold', 'additional_price' => 0, 'sort_order' => 6],
            ['type' => 'color', 'name' => 'Pastel', 'additional_price' => 0, 'sort_order' => 7],
            ['type' => 'color', 'name' => 'Custom', 'additional_price' => 0, 'sort_order' => 8],
            
            // Addons
            ['type' => 'addon', 'name' => 'Lampu LED', 'additional_price' => 15000, 'sort_order' => 1],
            ['type' => 'addon', 'name' => 'Kartu Ucapan Gratis', 'additional_price' => 0, 'sort_order' => 2],
            ['type' => 'addon', 'name' => 'Boneka Mini', 'additional_price' => 25000, 'sort_order' => 3],
            ['type' => 'addon', 'name' => 'Cokelat', 'additional_price' => 20000, 'sort_order' => 4],
        ];

        // Add timestamps
        foreach ($data as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
            $row['is_active'] = 1;
        }

        $this->db->table('custom_options')->insertBatch($data);
    }
}
