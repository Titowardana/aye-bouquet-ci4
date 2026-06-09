<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table            = 'order_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'order_id',
        'product_id',
        'variant_id',
        'product_name',
        'category_name',
        'variant_name',
        'sku',
        'product_url',
        'custom_note',
        'qty',
        'price',
        'subtotal',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}