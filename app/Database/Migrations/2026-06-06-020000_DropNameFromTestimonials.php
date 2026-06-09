<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropNameFromTestimonials extends Migration
{
    public function up()
    {
        if ($this->db->fieldExists('name', 'testimonials')) {
            $this->forge->dropColumn('testimonials', 'name');
        }
    }

    public function down()
    {
        $this->forge->addColumn('testimonials', [
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => '',
            ],
        ]);
    }
}
