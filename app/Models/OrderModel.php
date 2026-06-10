<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'order_code',
        'customer_name',
        'recipient_name',
        'phone',
        'delivery_method',
        'address',
        'delivery_date',
        'delivery_time',
        'greeting_card',
        'notes',
        'subtotal',
        'total_items',
        'status',
        'wa_message',
        'is_archived',
        'archived_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function generateOrderCode(): string
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    public function archive(int $id): bool
    {
        return $this->update($id, [
            'is_archived' => 1,
            'archived_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function restore(int $id): bool
    {
        return $this->update($id, [
            'is_archived' => 0,
            'archived_at' => null,
        ]);
    }

    public function getFilteredOrders(array $filters = [], int $perPage = 15, bool $archived = false)
    {
        $builder = $this->orderBy('created_at', 'DESC');

        $builder->where('is_archived', $archived ? 1 : 0);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                    ->like('order_code', $search)
                    ->orLike('customer_name', $search)
                    ->orLike('phone', $search)
                    ->groupEnd();
        }

        if (!empty($filters['status'])) {
            $builder->where('status', $filters['status']);
        }

        if (!empty($filters['date_start'])) {
            $builder->where('created_at >=', $filters['date_start'] . ' 00:00:00');
        }

        if (!empty($filters['date_end'])) {
            $builder->where('created_at <=', $filters['date_end'] . ' 23:59:59');
        }

        return $this->paginate($perPage, 'admin_pagination');
    }
}