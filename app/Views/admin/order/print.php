<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pesanan - Aye Bouquet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0 0 5px 0;
            font-size: 24px;
        }
        .header p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        .summary {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        .summary div {
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
            }
        }
        .print-btn {
            display: block;
            margin: 0 auto 20px auto;
            padding: 10px 20px;
            background-color: #795465;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .print-btn:hover {
            background-color: #5c3f4c;
        }
    </style>
</head>
<body>
    <button class="print-btn no-print" onclick="window.print()">Print / Save as PDF</button>

    <div class="header">
        <h1>Laporan Pesanan Aye Bouquet</h1>
        <p>Tanggal Cetak: <?= date('d-m-Y H:i:s') ?> WIB</p>
        <?php if (!empty($dateStart) || !empty($dateEnd)): ?>
            <p>Periode: <?= !empty($dateStart) ? formatTanggalIndo($dateStart) : 'Awal' ?> s/d <?= !empty($dateEnd) ? formatTanggalIndo($dateEnd) : 'Sekarang' ?></p>
        <?php endif; ?>
        <?php if (!empty($selectedStatus)): ?>
            <p>Status: <?= ucfirst($selectedStatus) ?></p>
        <?php endif; ?>
        <?php if (!empty($search)): ?>
            <p>Pencarian: <?= esc($search) ?></p>
        <?php endif; ?>
    </div>

    <div class="summary">
        <div>Total Pesanan: <strong><?= count($orders) ?></strong></div>
        <?php 
            $totalAmount = 0;
            foreach ($orders as $order) {
                $totalAmount += (int) $order['subtotal'];
            }
        ?>
        <div>Total Nominal: <strong>Rp <?= number_format($totalAmount, 0, ',', '.') ?></strong></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Order</th>
                <th>Waktu Pesanan</th>
                <th>Nama Customer</th>
                <th>No WhatsApp</th>
                <th>Status</th>
                <th class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data pesanan.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($order['order_code']) ?></td>
                        <td><?= formatDatetimeIndo($order['created_at']) ?></td>
                        <td><?= esc($order['customer_name']) ?></td>
                        <td><?= esc($order['phone']) ?></td>
                        <td><?= esc(ucfirst($order['status'])) ?></td>
                        <td class="text-right"><?= number_format((int) $order['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="6" class="text-right">Total Keseluruhan</td>
                    <td class="text-right"><?= number_format($totalAmount, 0, ',', '.') ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        // Optional: auto print when page loads
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
