<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductColorsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'hex_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('name');
        $this->forge->createTable('product_colors');

        // Insert default colors
        $this->db->table('product_colors')->insertBatch([
            ['name' => 'Pink',   'hex_code' => '#ec5aa6', 'is_active' => 1, 'sort_order' => 1],
            ['name' => 'Merah',  'hex_code' => '#e52525', 'is_active' => 1, 'sort_order' => 2],
            ['name' => 'Putih',  'hex_code' => '#ffffff', 'is_active' => 1, 'sort_order' => 3],
            ['name' => 'Biru',   'hex_code' => '#3b82f6', 'is_active' => 1, 'sort_order' => 4],
            ['name' => 'Ungu',   'hex_code' => '#a855f7', 'is_active' => 1, 'sort_order' => 5],
            ['name' => 'Kuning', 'hex_code' => '#facc15', 'is_active' => 1, 'sort_order' => 6],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('product_colors');
    }
}
