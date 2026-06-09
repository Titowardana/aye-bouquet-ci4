<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductVariantModel extends Model
{
    protected $table            = 'product_variants';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'product_id', 'size_label', 'price', 'description', 'is_active', 'sort_order',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'product_id' => 'required|integer',
        'size_label' => 'required|max_length[50]',
        'price'      => 'required|numeric',
    ];

    /**
     * Get all variants for a product
     */
    public function getByProduct(int $productId): array
    {
        return $this->where('product_id', $productId)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }
}
