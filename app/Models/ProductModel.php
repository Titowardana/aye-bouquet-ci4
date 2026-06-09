<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'category_id', 'name', 'slug', 'sku', 'description',
        'price', 'status', 'is_featured', 'is_active', 'sort_order',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name'        => 'required|max_length[200]',
        'category_id' => 'required|integer',
        'price'       => 'required|numeric',
    ];

    /**
     * Get products with category name and primary image.
     *
     * $frontendOnly=true dipakai untuk halaman publik: hanya produk aktif dari kategori aktif.
     * $frontendOnly=false dipakai admin: semua produk tetap terlihat agar bisa dikelola.
     */
    public function getProductsWithCategory(array $filters = [], int $perPage = 10, bool $frontendOnly = true)
    {
        $builder = $this->select('products.*, categories.name as category_name, categories.is_active as category_is_active')
                        ->join('categories', 'categories.id = products.category_id', 'left');

        if ($frontendOnly) {
            $builder->where('categories.is_active', 1)
                    ->where('products.is_active', 1);
        }

        if (!empty($filters['category_id'])) {
            $builder->where('products.category_id', $filters['category_id']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart()
                    ->like('products.name', $filters['search'])
                    ->orLike('products.sku', $filters['search'])
                    ->groupEnd();
        }

        if (!empty($filters['status'])) {
            $builder->where('products.status', strtolower($filters['status']));
        }

        if (!empty($filters['price_range'])) {
            switch ($filters['price_range']) {
                case 'under_50':
                    $builder->where('products.price <', 50000);
                    break;
                case '50_100':
                    $builder->where('products.price >=', 50000)->where('products.price <=', 100000);
                    break;
                case '100_200':
                    $builder->where('products.price >=', 100000)->where('products.price <=', 200000);
                    break;
                case '200_500':
                    $builder->where('products.price >=', 200000)->where('products.price <=', 500000);
                    break;
                case 'above_500':
                    $builder->where('products.price >', 500000);
                    break;
            }
        }

        if (!empty($filters['ukuran']) && is_array($filters['ukuran'])) {
            $builder->join('product_variants', 'product_variants.product_id = products.id', 'inner')
                    ->whereIn('product_variants.size_label', $filters['ukuran'])
                    ->groupBy('products.id');
        }

        if (!empty($filters['warna'])) {
            $builder->groupStart()
                    ->like('products.name', $filters['warna'])
                    ->orLike('products.description', $filters['warna'])
                    ->groupEnd();
        }

        if (!empty($filters['sort'])) {
            if ($filters['sort'] == 'harga_rendah') {
                $builder->orderBy('products.price', 'ASC');
            } elseif ($filters['sort'] == 'harga_tinggi') {
                $builder->orderBy('products.price', 'DESC');
            } else {
                $builder->orderBy('products.created_at', 'DESC');
            }
        } else {
            $builder->orderBy('products.created_at', 'DESC');
        }

        return $builder->paginate($perPage);
    }

    /**
     * Get a single product with all related data
     */
    public function getProductDetail(int $id): ?array
    {
        $product = $this->select('products.*, categories.name as category_name')
                        ->join('categories', 'categories.id = products.category_id', 'left')
                        ->find($id);

        if ($product) {
            $variantModel = new ProductVariantModel();
            $imageModel   = new ProductImageModel();

            $product['variants'] = $variantModel->where('product_id', $id)
                                                ->orderBy('sort_order', 'ASC')
                                                ->findAll();
            $product['images']   = $imageModel->where('product_id', $id)
                                              ->orderBy('is_primary', 'DESC')
                                              ->orderBy('sort_order', 'ASC')
                                              ->findAll();
        }

        return $product;
    }

    /**
     * Get primary image filename for a product
     */
    public function getPrimaryImage(int $productId): ?string
    {
        $imageModel = new ProductImageModel();
        $image = $imageModel->where('product_id', $productId)
                            ->orderBy('is_primary', 'DESC')
                            ->first();
        return $image ? $image['image'] : null;
    }

    /**
     * Generate unique slug from product name
     */
    public function generateSlug(string $name, ?int $excludeId = null): string
    {
        $slug = url_title($name, '-', true);
        $builder = $this->where('slug', $slug);

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        if ($builder->countAllResults() > 0) {
            $slug .= '-' . time();
        }

        return $slug;
    }
}
