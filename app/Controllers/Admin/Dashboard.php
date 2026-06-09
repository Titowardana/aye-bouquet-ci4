<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\TestimonialModel;
use App\Models\OrderModel;

class Dashboard extends BaseController
{
    public function index()
    {
        /*
         * Catatan:
         * Setiap query statistik memakai instance model baru.
         * Tujuannya agar kondisi query seperti where(), join(), orderBy(),
         * dan limit() tidak terbawa ke query berikutnya.
         */

        // Statistik utama dashboard
        $totalProducts = (new ProductModel())
            ->countAllResults();

        $totalCategories = (new CategoryModel())
            ->where('is_active', 1)
            ->countAllResults();

        $totalTestimonials = (new TestimonialModel())
            ->where('is_approved', 1)
            ->countAllResults();

        $totalOrders = (new OrderModel())->countAllResults();

        $newOrders = (new OrderModel())
            ->where('status', 'baru')
            ->countAllResults();

        $latestOrders = (new OrderModel())
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->findAll();

        $avgRating = (new TestimonialModel())
            ->getAverageRating();

        $readyCount = (new ProductModel())
            ->where('status', 'ready')
            ->countAllResults();

        // Produk terbaru untuk tabel dashboard
        $recentProducts = (new ProductModel())
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->orderBy('products.created_at', 'DESC')
            ->limit(4)
            ->findAll();

        // Ulasan terbaru yang sudah disetujui
        $latestTestimonials = (new TestimonialModel())
            ->where('is_approved', 1)
            ->orderBy('created_at', 'DESC')
            ->limit(3)
            ->findAll();

        // Produk yang ditambahkan dalam 7 hari terakhir
        $weekAgo = date('Y-m-d H:i:s', strtotime('-7 days'));

        $newProductsThisWeek = (new ProductModel())
            ->where('created_at >=', $weekAgo)
            ->countAllResults();

        $data = [
            'title'               => 'Dashboard Overview - Aye Bouquet',
            'pageTitle'           => 'Dashboard Overview',
            'activeMenu'          => 'dashboard',

            'totalProducts'       => $totalProducts,
            'totalCategories'     => $totalCategories,
            'totalTestimonials'   => $totalTestimonials,
            'avgRating'           => $avgRating,
            'readyCount'          => $readyCount,

            'totalOrders'         => $totalOrders,
            'newOrders'           => $newOrders,
            'latestOrders'        => $latestOrders,

            'recentProducts'      => $recentProducts,
            'latestTestimonials'  => $latestTestimonials,
            'newProductsThisWeek' => $newProductsThisWeek,
        ];

        return view('admin/dashboard/index', $data);
    }
}