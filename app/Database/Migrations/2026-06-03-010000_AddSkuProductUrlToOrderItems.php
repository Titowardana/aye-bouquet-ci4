<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSkuProductUrlToOrderItems extends Migration
{
    public function up()
    {
        $fields = [];
        if (! $this->db->fieldExists('sku', 'order_items')) {
            $fields['sku'] = [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'variant_name',
            ];
        }
        if (! $this->db->fieldExists('product_url', 'order_items')) {
            $fields['product_url'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'sku',
            ];
        }
        if ($fields !== []) {
            $this->forge->addColumn('order_items', $fields);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('product_url', 'order_items')) {
            $this->forge->dropColumn('order_items', 'product_url');
        }
        if ($this->db->fieldExists('sku', 'order_items')) {
            $this->forge->dropColumn('order_items', 'sku');
        }
    }
}
