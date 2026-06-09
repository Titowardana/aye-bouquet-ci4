<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'name', 'slug', 'description', 'icon', 'is_active', 'sort_order',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name' => 'required|max_length[100]',
        'slug' => 'required|max_length[100]|is_unique[categories.slug,id,{id}]',
    ];

    /**
     * Get all active categories ordered by sort_order
     */
    public function getActiveCategories(): array
    {
        return $this->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }


    /**
     * Get all categories for admin pages, including inactive categories.
     */
    public function getAllForAdmin(): array
    {
        return $this->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }

    /**
     * Find an active category by slug for frontend filters.
     */
    public function getActiveBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)
                    ->where('is_active', 1)
                    ->first();
    }

    /**
     * Count products in this category
     */
    public function countProducts(int $categoryId): int
    {
        $productModel = new ProductModel();
        return $productModel->where('category_id', $categoryId)->countAllResults();
    }
}
