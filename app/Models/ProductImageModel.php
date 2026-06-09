<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductImageModel extends Model
{
    protected $table            = 'product_images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'product_id', 'image', 'is_primary', 'sort_order',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get images for a product, primary first
     */
    public function getByProduct(int $productId): array
    {
        return $this->where('product_id', $productId)
                    ->orderBy('is_primary', 'DESC')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Set a new primary image for a product
     */
    public function setPrimary(int $productId, int $imageId): void
    {
        // Unset all primary flags for this product
        $this->where('product_id', $productId)->set(['is_primary' => 0])->update();
        // Set the new primary
        $this->update($imageId, ['is_primary' => 1]);
    }
}
