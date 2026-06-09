<?php

namespace App\Controllers;

use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\SettingModel;

class Checkout extends BaseController
{
    public function index()
    {
        $orderItems = session_cart_items();

        if (empty($orderItems)) {
            return redirect()->to(base_url('/keranjang'))
                ->with('error', 'Keranjang masih kosong. Silakan pilih produk terlebih dahulu.');
        }

        $subtotal = array_sum(array_map(static function ($item) {
            return (int) $item['harga'] * (int) $item['qty'];
        }, $orderItems));

        $totalItems = array_sum(array_map(static function ($item) {
            return (int) $item['qty'];
        }, $orderItems));

        $contacts = (new SettingModel())->getContactSettings();

        $data = [
            'title'      => 'Checkout Pesanan | Aye Bouquet',
            'activeMenu' => '',
            'orderItems' => $orderItems,
            'subtotal'   => $subtotal,
            'totalItems' => $totalItems,
            'waNumber'   => (new SettingModel())->normalizeWhatsapp($contacts['whatsapp'] ?? '6281234567890'),
        ];

        return view('pages/checkout', $data);
    }

    public function process()
    {
        $cartItems = session_cart_items();

        if (empty($cartItems)) {
            return redirect()->to(base_url('/keranjang'))
                ->with('error', 'Keranjang masih kosong. Silakan pilih produk terlebih dahulu.');
        }

        $rules = [
            'nama_pemesan' => 'required|min_length[3]|max_length[100]',
            'no_hp'        => 'required|min_length[8]|max_length[20]',
            'metode'       => 'required|in_list[ambil_toko,kurir]',
            'tanggal'      => 'required|valid_date[Y-m-d]',
            'jam'          => 'required|max_length[50]',
        ];

        $messages = [
            'metode' => [
                'required' => 'Pilih metode pengambilan atau pengiriman.',
                'in_list'  => 'Metode pengambilan/pengiriman tidak valid.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('error', 'Mohon lengkapi data checkout dengan benar.');
        }

        $customerName   = trim((string) $this->request->getPost('nama_pemesan'));
        $recipientName  = trim((string) $this->request->getPost('nama_penerima'));
        $phone          = trim((string) $this->request->getPost('no_hp'));
        $phone = ltrim($phone, '+');
        $phone = preg_replace('/^(62|0)/', '', $phone);
        $method         = trim((string) $this->request->getPost('metode'));
        $address        = trim((string) $this->request->getPost('alamat'));
        $deliveryDate   = $this->request->getPost('tanggal');
        $deliveryTime   = $this->request->getPost('jam');
        // Append :00 if only HH:MM was sent
        if ($deliveryTime && preg_match('/^\d{2}:\d{2}$/', $deliveryTime)) {
            $deliveryTime .= ':00';
        }
        $greetingCard   = trim((string) $this->request->getPost('kartu_ucapan'));
        $notes          = trim((string) $this->request->getPost('catatan'));

        if ($method === 'kurir' && $address === '') {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['alamat' => 'Alamat wajib diisi jika memilih pengiriman via kurir.'])
                ->with('error', 'Alamat wajib diisi jika memilih pengiriman via kurir.');
        }

        foreach ($cartItems as $item) {
            if (empty($item['product_id']) || (int) ($item['qty'] ?? 0) < 1 || (int) ($item['harga'] ?? 0) < 0) {
                return redirect()->to(base_url('/keranjang'))
                    ->with('error', 'Data keranjang tidak valid. Silakan hapus item bermasalah lalu tambahkan produk kembali.');
            }
        }

        $subtotal = array_sum(array_map(static function ($item) {
            return (int) $item['harga'] * (int) $item['qty'];
        }, $cartItems));

        $totalItems = array_sum(array_map(static function ($item) {
            return (int) $item['qty'];
        }, $cartItems));

        $orderModel     = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $settingModel   = new SettingModel();

        $orderCode = $orderModel->generateOrderCode();

        $message = $this->buildWhatsAppMessage([
            'order_code'     => $orderCode,
            'customer_name'  => $customerName,
            'recipient_name' => $recipientName,
            'phone'          => $phone,
            'method'         => $method,
            'address'        => $address,
            'delivery_date'  => $deliveryDate,
            'delivery_time'  => $deliveryTime,
            'greeting_card'  => $greetingCard,
            'notes'          => $notes,
            'subtotal'       => $subtotal,
            'items'          => $cartItems,
        ]);

        $db = db_connect();
        $db->transBegin();

        $orderId = $orderModel->insert([
            'order_code'       => $orderCode,
            'customer_name'    => $customerName,
            'recipient_name'   => $recipientName ?: null,
            'phone'            => $phone,
            'delivery_method'  => $method,
            'address'          => $address ?: null,
            'delivery_date'    => $deliveryDate,
            'delivery_time'    => $deliveryTime,
            'greeting_card'    => $greetingCard ?: null,
            'notes'            => $notes ?: null,
            'subtotal'         => $subtotal,
            'total_items'      => $totalItems,
            'status'           => 'baru',
            'wa_message'       => $message,
        ], true);

        if (! $orderId) {
            $db->transRollback();
            log_message('error', 'Checkout: order insert failed. model errors: ' . json_encode($orderModel->errors()) . ' | db error: ' . json_encode($db->error()));
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pesanan gagal disimpan. Periksa data checkout lalu coba lagi.');
        }

        foreach ($cartItems as $item) {
            $qty   = (int) ($item['qty'] ?? 1);
            $price = (int) ($item['harga'] ?? 0);

            $saved = $orderItemModel->insert([
                'order_id'      => $orderId,
                'product_id'    => (int) $item['product_id'],
                'variant_id'    => !empty($item['variant_id']) ? (int) $item['variant_id'] : null,
                'product_name'  => $item['nama'] ?? '-',
                'category_name' => $item['kategori'] ?? null,
                'variant_name'  => $item['ukuran'] ?? null,
                'sku'           => $item['sku'] ?? null,
                'product_url'   => $item['link'] ?? (!empty($item['slug']) ? base_url('produk/' . $item['slug']) : null),
                'custom_note'   => $item['catatan'] ?? null,
                'qty'           => $qty,
                'price'         => $price,
                'subtotal'      => $qty * $price,
            ]);

            if (! $saved) {
                $db->transRollback();
                log_message('error', 'Checkout: order_item insert failed. model errors: ' . json_encode($orderItemModel->errors()) . ' | db error: ' . json_encode($db->error()));
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Item pesanan gagal disimpan. Silakan coba lagi.');
            }
        }

        $db->transCommit();

        session()->remove(session_cart_key());

        $contacts = $settingModel->getContactSettings();
        $waNumber = $settingModel->normalizeWhatsapp($contacts['whatsapp'] ?? '6281234567890');
        $waUrl = 'https://wa.me/' . $waNumber . '?text=' . rawurlencode($message);

        return redirect()->to($waUrl);
    }

    private function buildWhatsAppMessage(array $data): string
    {
        $methodLabels = [
            'ambil_toko' => 'Ambil di Toko',
            'kurir'      => 'Kirim via Kurir',
        ];
        $data['method'] = $methodLabels[$data['method']] ?? $data['method'];

        $message  = "*Pesanan Baru - Aye Bouquet*\n";
        $message .= "Kode Pesanan: {$data['order_code']}\n\n";

        $message .= "*Data Pemesan*\n";
        $message .= "Nama Pemesan: {$data['customer_name']}\n";
        $message .= "Nama Penerima: " . ($data['recipient_name'] ?: '-') . "\n";
        $message .= "Nomor HP: {$data['phone']}\n\n";

        $message .= "*Detail Pengiriman/Pengambilan*\n";
        $message .= "Metode: {$data['method']}\n";
        $message .= "Alamat: " . ($data['address'] ?: '-') . "\n";
        $message .= "Tanggal: " . formatTanggalIndo($data['delivery_date']) . "\n";
        $message .= "Jam: " . formatJamIndo($data['delivery_time']) . "\n\n";

        $message .= "*Daftar Produk*\n";

        foreach ($data['items'] as $index => $item) {
            $no       = $index + 1;
            $name     = $item['nama'] ?? '-';
            $variant  = $item['ukuran'] ?? '-';
            $qty      = (int) ($item['qty'] ?? 1);
            $price    = (int) ($item['harga'] ?? 0);
            $lineSub  = $qty * $price;
            $note     = trim((string) ($item['catatan'] ?? ''));
            $sku      = $item['sku'] ?? '-';
            $category = $item['kategori'] ?? '-';
            $status   = $item['status'] ?? '-';
            $url      = $item['link'] ?? (!empty($item['slug']) ? base_url('produk/' . $item['slug']) : '-');

            $message .= "{$no}. {$name}\n";
            $message .= "   SKU: {$sku}\n";
            $message .= "   Kategori: {$category}\n";
            $message .= "   Varian/Ukuran: {$variant}\n";
            $message .= "   Status: {$status}\n";
            $message .= "   Qty: {$qty}\n";
            $message .= "   Harga: Rp " . number_format($price, 0, ',', '.') . "\n";
            $message .= "   Subtotal: Rp " . number_format($lineSub, 0, ',', '.') . "\n";
            $message .= "   Catatan Custom: " . ($note !== '' ? $note : '-') . "\n";
            $message .= "   Link Produk: {$url}\n\n";
        }

        $message .= "*Total Estimasi:* Rp " . number_format((int) $data['subtotal'], 0, ',', '.') . "\n\n";

        $message .= "*Kartu Ucapan:*\n";
        $message .= ($data['greeting_card'] ?: '-') . "\n\n";

        $message .= "*Catatan Tambahan:*\n";
        $message .= ($data['notes'] ?: '-') . "\n\n";

        $message .= "Mohon konfirmasi pesanan ini, ketersediaan produk, estimasi pengerjaan, ongkir jika ada, total pembayaran, dan metode pembayaran yang tersedia. Terima kasih.";

        return $message;
    }

}