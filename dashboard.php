<?php
include "koneksi.php";

// KPI Queries
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
    .dashboard-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        transition: 0.3s ease;
    }
    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.08);
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
    }
    .bg-gradient-blue { background: linear-gradient(135deg, #4e54c8, #8f94fb); }
    .bg-gradient-teal { background: linear-gradient(135deg, #11998e, #38ef7d); }
    .bg-gradient-yellow { background: linear-gradient(135deg, #f7971e, #ffd200); }
    .bg-gradient-red { background: linear-gradient(135deg, #f953c6, #b91d73); }
    .object-fit-cover {
        object-fit: cover;
        object-position: center;
    }
</style>

<!-- DASHBOARD -->
<div class="container pt-4">
    <div class="row g-4 row-cols-1 row-cols-md-2 row-cols-lg-3">

        <!-- Total Produk -->
        <div class="col">
            <div class="card dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-badge bg-gradient-blue me-3">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fs-6 mb-1">Total Produk</h6>
                        <h3 class="fw-bold mb-0"><?= $total_produk ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Stok -->
        <div class="col">
            <div class="card dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-badge bg-gradient-teal me-3">
                        <i class="bi bi-stack"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fs-6 mb-1">Total Stok Barang</h6>
                        <h3 class="fw-bold mb-0"><?= $total_stok ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaksi Bulan Ini -->
        <div class="col">
            <div class="card dashboard-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase fs-6 mb-1">Transaksi Bulan Ini</h6>
                        <h3 class="fw-bold mb-0"><?= $trans_bulan_ini ?>
                            <span class="badge <?= $growth_trans >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?> ms-2">
                                <i class="bi <?= $growth_trans >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                                <?= abs($growth_trans) ?>%
                            </span>
                        </h3>
                        <p class="small text-muted mb-0">vs bulan lalu (<?= $trans_bulan_lalu ?> transaksi)</p>
                    </div>
                    <div class="icon-badge bg-gradient-yellow">
                        <i class="bi bi-receipt"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Bulan Ini -->
        <div class="col">
            <div class="card dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-badge bg-gradient-red me-3">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fs-6 mb-1">Revenue Bulan Ini</h6>
                        <h3 class="fw-bold mb-0">Rp <?= number_format($total_revenue, 0, ',', '.') ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk Terlaris -->
        <div class="col">
            <div class="card dashboard-card p-4 text-center">
                <h6 class="text-muted text-uppercase fs-6">Produk Terlaris</h6>
                <?php
                $gambar_terlaris = (!empty($produk_terlaris['gambar']) && file_exists("img/" . $produk_terlaris['gambar']))
                    ? $produk_terlaris['gambar']
                    : 'default.png';
                ?>
                <div class="ratio ratio-1x1 mb-2 rounded overflow-hidden shadow-sm" style="max-width: 90px; margin: 0 auto;">
                    <img src="img/<?= $gambar_terlaris ?>" class="w-100 h-100 object-fit-cover" alt="Produk Terlaris">
                </div>
                <h5 class="fw-bold"><?= $produk_terlaris['nama_brg'] ?? '-' ?></h5>
                <p class="mb-0 small text-muted">Terjual: <?= $produk_terlaris['total_jual'] ?? 0 ?> pcs</p>
            </div>
        </div>

        <!-- Produk Stok Rendah -->
        <div class="col">
            <div class="card dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-badge bg-gradient-red me-3">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fs-6 mb-1">Produk Stok Rendah</h6>
                        <h5 class="text-danger fw-bold mb-1"><?= $jumlah_stok_rendah ?> Produk</h5>
                        <p class="small mb-0">Segera lakukan restock<br>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#stokModal">Lihat detail</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- MODAL STOK RENDAH -->
<div class="modal fade" id="stokModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Detail Produk dengan Stok Rendah</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
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
