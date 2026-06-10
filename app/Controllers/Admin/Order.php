<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderItemModel;
use App\Models\OrderModel;

class Order extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();

        $filters = [
            'search'     => $this->request->getGet('search'),
            'status'     => $this->request->getGet('status'),
            'date_start' => $this->request->getGet('date_start'),
            'date_end'   => $this->request->getGet('date_end'),
        ];

        $orders = $orderModel->getFilteredOrders($filters, 15);

        $data = [
            'title'          => 'Kelola Pesanan - Admin',
            'pageTitle'      => 'Kelola Pesanan',
            'activeMenu'     => 'pesanan',
            'orders'         => $orders,
            'pager'          => $orderModel->pager,
            'search'         => $filters['search'],
            'selectedStatus' => $filters['status'],
            'dateStart'      => $filters['date_start'],
            'dateEnd'        => $filters['date_end'],
        ];

        return view('admin/order/index', $data);
    }

    public function detail($id)
    {
        $orderModel     = new OrderModel();
        $orderItemModel = new OrderItemModel();

        $order = $orderModel->find($id);

        if (!$order) {
            return redirect()->to(base_url('admin/pesanan'))
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        $items = $orderItemModel
            ->where('order_id', $id)
            ->findAll();

        $data = [
            'title'      => 'Detail Pesanan - Admin',
            'pageTitle'  => 'Detail Pesanan',
            'activeMenu' => 'pesanan',
            'order'      => $order,
            'items'      => $items,
        ];

        return view('admin/order/detail', $data);
    }

    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');

        $allowedStatus = ['baru', 'diproses', 'selesai', 'dibatalkan'];

        if (!in_array($status, $allowedStatus, true)) {
            return redirect()->back()
                ->with('error', 'Status pesanan tidak valid.');
        }

        $orderModel = new OrderModel();
        $order = $orderModel->find($id);

        if (!$order) {
            return redirect()->to(base_url('admin/pesanan'))
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        $orderModel->update($id, [
            'status' => $status,
        ]);

        return redirect()->back()
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function exportCsv()
    {
        $orderModel = new OrderModel();

        $filters = [
            'search'     => $this->request->getGet('search'),
            'status'     => $this->request->getGet('status'),
            'date_start' => $this->request->getGet('date_start'),
            'date_end'   => $this->request->getGet('date_end'),
        ];

        // Retrieve all matching records (use a large perPage)
        $orders = $orderModel->getFilteredOrders($filters, 10000);

        $filename = 'orders_aye_bouquet_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');

        // Write header row
        fputcsv($output, [
            'Kode Order',
            'Nama Customer',
            'Nomor WhatsApp',
            'Alamat',
            'Metode Pengiriman/Pengambilan',
            'Tanggal Pengiriman',
            'Jam Pengiriman',
            'Total',
            'Status',
            'Waktu Pesanan'
        ]);

        // Write data rows
        foreach ($orders as $order) {
            $deliveryDate = $order['delivery_date'] ? date('d-m-Y', strtotime($order['delivery_date'])) : '-';
            $deliveryTime = $order['delivery_time'] ? date('H:i', strtotime($order['delivery_time'])) . ' WIB' : '-';
            $orderDate    = $order['created_at'] ? date('d-m-Y H:i', strtotime($order['created_at'])) . ' WIB' : '-';
            $methodLabel = [
                'ambil_toko' => 'Ambil di Toko',
                'kurir'      => 'Kirim via Kurir',
            ][$order['delivery_method']] ?? $order['delivery_method'];

            fputcsv($output, [
                $order['order_code'],
                $order['customer_name'],
                $order['phone'],
                $order['address'] ?: '-',
                $methodLabel,
                $deliveryDate,
                $deliveryTime,
                $order['subtotal'],
                ucfirst($order['status']),
                $orderDate
            ]);
        }

        fclose($output);
        exit;
    }

    public function print()
    {
        $orderModel = new OrderModel();

        $filters = [
            'search'     => $this->request->getGet('search'),
            'status'     => $this->request->getGet('status'),
            'date_start' => $this->request->getGet('date_start'),
            'date_end'   => $this->request->getGet('date_end'),
        ];

        // Retrieve all matching records (use a large perPage)
        $orders = $orderModel->getFilteredOrders($filters, 10000);

        $data = [
            'orders'         => $orders,
            'search'         => $filters['search'],
            'selectedStatus' => $filters['status'],
            'dateStart'      => $filters['date_start'],
            'dateEnd'        => $filters['date_end'],
        ];

        return view('admin/order/print', $data);
    }

    public function arsip()
    {
        $orderModel = new OrderModel();

        $filters = [
            'search'     => $this->request->getGet('search'),
            'status'     => $this->request->getGet('status'),
            'date_start' => $this->request->getGet('date_start'),
            'date_end'   => $this->request->getGet('date_end'),
        ];

        $orders = $orderModel->getFilteredOrders($filters, 15, true);

        $data = [
            'title'          => 'Arsip Pesanan - Admin',
            'pageTitle'      => 'Arsip Pesanan',
            'activeMenu'     => 'arsip-pesanan',
            'orders'         => $orders,
            'pager'          => $orderModel->pager,
            'search'         => $filters['search'],
            'selectedStatus' => $filters['status'],
            'dateStart'      => $filters['date_start'],
            'dateEnd'        => $filters['date_end'],
        ];

        return view('admin/order/archive', $data);
    }

    public function archive($id)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->find($id);

        if (!$order) {
            return redirect()->to(base_url('admin/pesanan'))
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($order['is_archived']) {
            return redirect()->back()
                ->with('error', 'Pesanan sudah diarsipkan.');
        }

        $orderModel->archive((int) $id);

        return redirect()->to(base_url('admin/pesanan'))
            ->with('success', 'Pesanan berhasil diarsipkan.');
    }

    public function restore($id)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->find($id);

        if (!$order) {
            return redirect()->to(base_url('admin/pesanan/arsip'))
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        if (!$order['is_archived']) {
            return redirect()->to(base_url('admin/pesanan/arsip'))
                ->with('error', 'Pesanan tidak dalam status arsip.');
        }

        $orderModel->restore((int) $id);

        return redirect()->to(base_url('admin/pesanan/arsip'))
            ->with('success', 'Pesanan berhasil dipulihkan.');
    }

    public function deletePermanent($id)
    {
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();

        $order = $orderModel->find($id);

        if (!$order) {
            return redirect()->to(base_url('admin/pesanan/arsip'))
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        if (!$order['is_archived']) {
            return redirect()->to(base_url('admin/pesanan'))
                ->with('error', 'Hanya pesanan yang sudah diarsipkan yang dapat dihapus permanen.');
        }

        // Delete order items first (no foreign key cascade)
        $orderItemModel->where('order_id', $id)->delete();

        // Delete the order
        $orderModel->delete($id);

        return redirect()->to(base_url('admin/pesanan/arsip'))
            ->with('success', 'Pesanan beserta itemnya berhasil dihapus permanen.');
    }

    public function bulkArchive()
    {
        $orderIds = $this->request->getPost('order_ids');

        if (empty($orderIds) || !is_array($orderIds)) {
            return redirect()->to(base_url('admin/pesanan'))
                ->with('error', 'Tidak ada pesanan yang dipilih.');
        }

        $orderIds = array_map('intval', $orderIds);
        $orderIds = array_filter($orderIds, fn($v) => $v > 0);

        if (empty($orderIds)) {
            return redirect()->to(base_url('admin/pesanan'))
                ->with('error', 'ID pesanan tidak valid.');
        }

        $orderModel = new OrderModel();
        $now = date('Y-m-d H:i:s');

        // Only update orders that are NOT already archived
        $orderModel->whereIn('id', $orderIds)
            ->where('is_archived', 0)
            ->set(['is_archived' => 1, 'archived_at' => $now])
            ->update();

        $affected = $orderModel->affectedRows();

        return redirect()->to(base_url('admin/pesanan'))
            ->with('success', $affected . ' pesanan berhasil diarsipkan.');
    }

    public function bulkDeletePermanent()
    {
        $orderIds = $this->request->getPost('order_ids');

        if (empty($orderIds) || !is_array($orderIds)) {
            return redirect()->to(base_url('admin/pesanan/arsip'))
                ->with('error', 'Tidak ada pesanan yang dipilih.');
        }

        $orderIds = array_map('intval', $orderIds);
        $orderIds = array_filter($orderIds, fn($v) => $v > 0);

        if (empty($orderIds)) {
            return redirect()->to(base_url('admin/pesanan/arsip'))
                ->with('error', 'ID pesanan tidak valid.');
        }

        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();

        // Only delete orders that ARE archived (is_archived = 1)
        $validOrders = $orderModel->whereIn('id', $orderIds)
            ->where('is_archived', 1)
            ->findAll();

        if (empty($validOrders)) {
            return redirect()->to(base_url('admin/pesanan/arsip'))
                ->with('error', 'Tidak ada pesanan arsip yang valid untuk dihapus.');
        }

        $validIds = array_column($validOrders, 'id');

        // Delete order items first (no foreign key cascade)
        $orderItemModel->whereIn('order_id', $validIds)->delete();

        // Delete the orders
        $orderModel->whereIn('id', $validIds)->delete();

        $count = count($validIds);

        return redirect()->to(base_url('admin/pesanan/arsip'))
            ->with('success', $count . ' pesanan berhasil dihapus permanen.');
    }

    public function bulkRestore()
    {
        $orderIds = $this->request->getPost('order_ids');

        if (empty($orderIds) || !is_array($orderIds)) {
            return redirect()->to(base_url('admin/pesanan/arsip'))
                ->with('error', 'Tidak ada pesanan yang dipilih.');
        }

        $orderIds = array_map('intval', $orderIds);
        $orderIds = array_filter($orderIds, fn($v) => $v > 0);

        if (empty($orderIds)) {
            return redirect()->to(base_url('admin/pesanan/arsip'))
                ->with('error', 'ID pesanan tidak valid.');
        }

        $orderModel = new OrderModel();

        // Only restore orders that ARE archived
        $orderModel->whereIn('id', $orderIds)
            ->where('is_archived', 1)
            ->set(['is_archived' => 0, 'archived_at' => null])
            ->update();

        $affected = $orderModel->affectedRows();

        return redirect()->to(base_url('admin/pesanan/arsip'))
            ->with('success', $affected . ' pesanan berhasil dipulihkan.');
    }
}