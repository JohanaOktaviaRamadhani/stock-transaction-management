<?php
include "koneksi.php";

// Data KPI
$bulan_ini = date('Y-m');
$bulan_lalu = date('Y-m', strtotime('-1 month'));

$total_produk = $conn->query("SELECT COUNT(*) AS total FROM tbl_stok")->fetch_assoc()['total'];
$total_stok = $conn->query("SELECT SUM(stok) AS total FROM tbl_stok")->fetch_assoc()['total'];

$trans_bulan_ini = $conn->query("SELECT COUNT(*) AS total FROM tbl_transaksi WHERE DATE_FORMAT(tgl_trans, '%Y-%m') = '$bulan_ini'")->fetch_assoc()['total'];
$trans_bulan_lalu = $conn->query("SELECT COUNT(*) AS total FROM tbl_transaksi WHERE DATE_FORMAT(tgl_trans, '%Y-%m') = '$bulan_lalu'")->fetch_assoc()['total'];
$growth_trans = $trans_bulan_lalu > 0 ? round((($trans_bulan_ini - $trans_bulan_lalu) / $trans_bulan_lalu) * 100) : 100;

$total_revenue = $conn->query("SELECT SUM(subtotal) AS total FROM tbl_transaksi WHERE DATE_FORMAT(tgl_trans, '%Y-%m') = '$bulan_ini'")->fetch_assoc()['total'] ?? 0;

$produk_terlaris = $conn->query("
    SELECT s.nama_brg, s.gambar, SUM(t.jml_jual) AS total_jual 
    FROM tbl_transaksi t 
    JOIN tbl_stok s ON t.id_brg = s.id_brg 
    GROUP BY t.id_brg 
    ORDER BY total_jual DESC 
    LIMIT 1
")->fetch_assoc();

$stok_rendah_q = $conn->query("SELECT nama_brg, stok FROM tbl_stok WHERE stok < 10 ORDER BY stok ASC");
$jumlah_stok_rendah = $stok_rendah_q->num_rows;
?>

<!-- STYLES -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
<style>
    body {
        background-color: #f7f2f9;
        font-family: 'Segoe UI', sans-serif;
    }
    .dashboard-wrapper {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 12px 40px rgba(168, 130, 191, 0.1);
        margin-top: 2rem;
    }
    .dashboard-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #5a3e91;
        margin-bottom: 1rem;
    }
    .dashboard-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(162, 120, 190, 0.12);
        background-color: #ffffff;
        transition: 0.3s ease;
        height: 100%;
    }
    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(162, 120, 190, 0.2);
    }
    .icon-badge {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.4rem;
        color: white;
        flex-shrink: 0;
    }
    .bg-gradient-lilac { background: linear-gradient(135deg, #cbaacb, #e0bbe4); }
    .bg-gradient-indigo { background: linear-gradient(135deg, #a18cd1, #fbc2eb); }
    .bg-gradient-softpink { background: linear-gradient(135deg, #fbc2eb, #a6c1ee); }
    .bg-gradient-magenta { background: linear-gradient(135deg, #f093fb, #f5576c); }
    .text-muted-soft { color: #888 !important; }
    .badge-soft-success {
        background-color: #e6f4ea;
        color: #4caf50;
        font-size: 0.85rem;
    }
    .badge-soft-danger {
        background-color: #fbeaea;
        color: #f44336;
        font-size: 0.85rem;
    }
    .card-body h3 {
        font-size: 1.8rem;
        color: #4a2f7c;
    }
</style>

<!-- DASHBOARD -->
<div class="container dashboard-wrapper">
    <div class="dashboard-header text-center">
        <div class="dashboard-title">Statistik Bulan <?= date('F Y') ?></div>
    </div>

    <div class="row g-4 row-cols-1 row-cols-md-2 row-cols-lg-3">

        <!-- Total Produk -->
        <div class="col">
            <div class="card dashboard-card p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="icon-badge bg-gradient-lilac me-3">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <h6 class="text-muted-soft text-uppercase mb-1">Total Produk</h6>
                        <h3 class="fw-bold mb-0"><?= $total_produk ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Stok -->
        <div class="col">
            <div class="card dashboard-card p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="icon-badge bg-gradient-indigo me-3">
                        <i class="bi bi-stack"></i>
                    </div>
                    <div>
                        <h6 class="text-muted-soft text-uppercase mb-1">Total Stok Barang</h6>
                        <h3 class="fw-bold mb-0"><?= $total_stok ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaksi Bulan Ini -->
        <div class="col">
            <div class="card dashboard-card p-4 d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted-soft text-uppercase mb-1">Transaksi Bulan Ini</h6>
                        <h3 class="fw-bold mb-0"><?= $trans_bulan_ini ?>
                            <span class="badge <?= $growth_trans >= 0 ? 'badge-soft-success' : 'badge-soft-danger' ?> ms-2">
                                <i class="bi <?= $growth_trans >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                                <?= abs($growth_trans) ?>%
                            </span>
                        </h3>
                        <p class="small text-muted mb-0">vs bulan lalu (<?= $trans_bulan_lalu ?> transaksi)</p>
                    </div>
                    <div class="icon-badge bg-gradient-softpink">
                        <i class="bi bi-receipt"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Bulan Ini -->
        <div class="col">
            <div class="card dashboard-card p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="icon-badge bg-gradient-magenta me-3">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <h6 class="text-muted-soft text-uppercase mb-1">Revenue Bulan Ini</h6>
                        <h3 class="fw-bold mb-0">Rp <?= number_format($total_revenue, 0, ',', '.') ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk Terlaris -->
        <div class="col">
            <div class="card dashboard-card p-4 text-center">
                <h6 class="text-muted-soft text-uppercase mb-2">Produk Terlaris</h6>
                <?php if ($produk_terlaris): ?>
                    <h5 class="fw-bold"><?= $produk_terlaris['nama_brg'] ?></h5>
                    <p class="mb-0 small text-muted">Terjual: <?= $produk_terlaris['total_jual'] ?> pcs</p>
                <?php else: ?>
                    <p class="text-muted">Belum ada data</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Produk Stok Rendah -->
        <div class="col">
            <div class="card dashboard-card p-4 d-flex flex-column justify-content-between">
                <h6 class="text-muted-soft text-uppercase mb-1">Produk Stok Rendah</h6>
                <h5 class="text-danger fw-bold"><?= $jumlah_stok_rendah ?> Produk</h5>
                <p class="small mb-0">Segera lakukan restock <br>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#stokModal">Lihat detail</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- MODAL STOK RENDAH -->
<div class="modal fade" id="stokModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Produk dengan Stok Rendah</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead><tr><th>Nama Produk</th><th>Stok</th></tr></thead>
                    <tbody>
                        <?php while ($row = $stok_rendah_q->fetch_assoc()): ?>
                            <tr><td><?= $row['nama_brg'] ?></td><td><?= $row['stok'] ?></td></tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
