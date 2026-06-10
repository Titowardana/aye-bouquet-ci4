<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColorToProducts extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('color', 'products')) {
            $this->forge->addColumn('products', [
                'color' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                    'default'    => null,
                    'after'      => 'status',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('color', 'products')) {
            $this->forge->dropColumn('products', 'color');
        }
    }
}
