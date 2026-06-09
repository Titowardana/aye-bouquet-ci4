<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends Model
{
    protected $table            = 'galleries';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'title', 'image', 'description', 'category', 'is_active', 'sort_order',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getActive(int $limit = 20, string $category = 'product_gallery'): array
    {
        $builder = $this->where('is_active', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('created_at', 'DESC');

        if ($category === 'product_gallery') {
            // Include empty category or legacy values as product_gallery fallback
            $builder->groupStart()
                    ->where('category', 'product_gallery')
                    ->orWhere('category', null)
                    ->orWhere('category', '')
                    ->orWhereNotIn('category', ['about_story', 'banner', 'other'])
                    ->groupEnd();
        } else {
            $builder->where('category', $category);
        }

        if ($limit > 0) {
            $builder->limit($limit);
        }

        return $builder->findAll();
    }
}
