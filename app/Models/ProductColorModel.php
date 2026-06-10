<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductColorModel extends Model
{
    protected $table            = 'product_colors';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'name', 'hex_code', 'is_active', 'sort_order',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name'       => 'required|max_length[50]|is_unique[product_colors.name,id,{id}]',
        'hex_code'   => 'permit_empty|regex_match[/^#[0-9a-fA-F]{6}$/]',
        'is_active'  => 'in_list[0,1]',
        'sort_order' => 'integer',
    ];

    public function getActiveColors(): array
    {
        return $this->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }

    public function getAllColors(): array
    {
        return $this->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }

    public function countProducts(int $colorId): int
    {
        $db = \Config\Database::connect();
        return $db->table('products')
                  ->join('product_colors', 'products.color = product_colors.name', 'left')
                  ->where('product_colors.id', $colorId)
                  ->countAllResults();
    }
}
