<?php

namespace App\Models;

use CodeIgniter\Model;

class TestimonialModel extends Model
{
    protected $table            = 'testimonials';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'customer_name', 'city', 'message', 'rating', 'product_id', 'photo', 'is_approved',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'customer_name' => 'required|max_length[100]',
        'city'          => 'permit_empty|max_length[100]',
        'message'       => 'required',
        'rating'        => 'required|integer|greater_than[0]|less_than[6]',
    ];

    /**
     * Get approved testimonials for the public page
     */
    public function getApproved(int $limit = 10): array
    {
        return $this->where('is_approved', 1)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get average rating
     */
    public function getAverageRating(): float
    {
        $result = $this->selectAvg('rating', 'avg_rating')
                       ->where('is_approved', 1)
                       ->first();
        return round((float)($result['avg_rating'] ?? 0), 1);
    }
}
