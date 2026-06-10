<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddArchivedAtToOrders extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('archived_at', 'orders')) {
            $this->forge->addColumn('orders', [
                'archived_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                    'after'   => 'status',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('archived_at', 'orders')) {
            $this->forge->dropColumn('orders', 'archived_at');
        }
    }
}
