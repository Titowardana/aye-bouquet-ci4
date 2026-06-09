<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomOptionModel extends Model
{
    protected $table            = 'custom_options';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'type', 'name', 'additional_price', 'sort_order', 'is_active',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'type' => 'required|in_list[size,color,addon]',
        'name' => 'required|max_length[100]',
        'additional_price' => 'required|integer',
        'sort_order' => 'required|integer',
    ];

    public function getFiltered(array $filters = [], int $perPage = 15)
    {
        $builder = $this->orderBy('type', 'ASC')->orderBy('sort_order', 'ASC');

        if (!empty($filters['search'])) {
            $builder->like('name', $filters['search']);
        }

        if (!empty($filters['type'])) {
            $builder->where('type', $filters['type']);
        }

        if ($filters['status'] === 'aktif') {
            $builder->where('is_active', 1);
        } elseif ($filters['status'] === 'nonaktif') {
            $builder->where('is_active', 0);
        }

        return $builder->paginate($perPage, 'admin_pagination');
    }

    public function getStats(): array
    {
        $all = $this->findAll();
        $total = count($all);
        $active = 0;
        $paidAddons = 0;
        $inactive = 0;

        foreach ($all as $opt) {
            if ($opt['is_active'] == 1) {
                $active++;
            } else {
                $inactive++;
            }
            if ($opt['type'] === 'addon' && $opt['additional_price'] > 0) {
                $paidAddons++;
            }
        }

        return [
            'total'      => $total,
            'active'     => $active,
            'paidAddons' => $paidAddons,
            'inactive'   => $inactive,
        ];
    }
}
