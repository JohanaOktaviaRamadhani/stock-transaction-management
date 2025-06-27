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

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

<style>
    /* ========== BASE ========== */
    :root {
    --lilac-gradient-start: #e7d0f8;
    --lilac-gradient-end: #f3e8ff;
    --lilac-muted: #d4c1ec;
    --lilac-dark: #5a3e91;
    --text-dark: #402660;
    --danger-soft: #fbeaea;
    --neon-lilac: #c69ff5;
    --neon-shadow: 0 0 8px #c69ff5, 0 0 16px #c69ff5aa;
    }

    body {
    background-color: #f7f2f9;
    font-family: 'Quicksand', sans-serif;
    color: #333;
    }

    /* ========== DASHBOARD WRAPPER ========== */
    .dashboard-wrapper {
    background: #ffffff;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 12px 40px rgba(168, 130, 191, 0.1);
    margin-top: 2rem;
    }

    .dashboard-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--lilac-dark);
    margin-bottom: 1rem;
    }

    /* ========== DASHBOARD CARD ========== */
    .dashboard-card {
    border: none;
    border-radius: 16px;
    background-color: #ffffff;
    box-shadow: 0 8px 24px rgba(162, 120, 190, 0.12);
    transition: 0.3s ease;
    height: 100%;
    position: relative;
    }

    .dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 0 10px #c69ff5, 0 0 20px rgba(198, 159, 245, 0.25);
    border: 1px solid var(--neon-lilac);
    }

    /* ========== ICON BADGES ========== */
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

    .bg-gradient-lilac {
    background: linear-gradient(135deg, #cbaacb, #e0bbe4);
    }

    .bg-gradient-indigo {
    background: linear-gradient(135deg, #a18cd1, #fbc2eb);
    }

    .bg-gradient-softpink {
    background: linear-gradient(135deg, #fbc2eb, #a6c1ee);
    }

    .bg-gradient-magenta {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    }

    /* ========== TEXT UTILITIES ========== */
    .text-muted-soft {
    color: #888 !important;
    }

    .card-body h3 {
    font-size: 1.8rem;
    color: var(--text-dark);
    }

    /* ========== BADGES ========== */
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

    .bg-danger-subtle {
    background-color: var(--danger-soft);
    color: #c62828;
    font-weight: 600;
    box-shadow: 0 0 6px rgba(245, 133, 133, 0.3);
    }

    .badge {
    transition: all 0.3s ease;
    font-family: 'Quicksand', sans-serif;
    }

    .badge:hover {
    transform: scale(1.05);
    opacity: 0.9;
    }

    /* ========== CARD TAMBAH TRANSAKSI & MODAL ========== */
    .card-tambah-transaksi {
    background: linear-gradient(to bottom right, var(--lilac-gradient-start), var(--lilac-gradient-end));
    border: 1px solid var(--lilac-muted);
    border-radius: 1rem;
    padding: 1.5rem;
    margin: 1rem 0;
    box-shadow: 0 6px 15px rgba(162, 139, 212, 0.1);
    animation: fadeInCard 0.5s ease-in-out;
    transition: 0.3s ease;
    }

    .card-tambah-transaksi:hover {
    border-color: var(--neon-lilac);
    box-shadow: var(--neon-shadow);
    }

    .card-tambah-transaksi .card-header h5 {
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
    }

    .card-tambah-transaksi .form-control,
    .card-tambah-transaksi .form-select {
    border-radius: 0.75rem;
    border: 1px solid var(--lilac-muted);
    }

    .card-tambah-transaksi .form-control:read-only {
    background-color: #f0eaff;
    color: #999;
    cursor: not-allowed;
    }

    .card-tambah-transaksi .form-control:focus,
    .card-tambah-transaksi .form-select:focus {
    border-color: var(--neon-lilac);
    box-shadow: 0 0 10px var(--neon-lilac);
    outline: none;
    }

    .card-tambah-transaksi .card-footer {
    border-top: 1px solid var(--lilac-muted);
    padding-top: 1rem;
    }

    /* ========== MODAL OVERRIDE STYLE ========== */
    .modal-content {
    border-radius: 1rem;
    box-shadow: 0 0 15px rgba(168, 130, 191, 0.25);
    background: linear-gradient(to bottom right, #f3e8ff, #e5dbf9);
    border: 1px solid var(--lilac-muted);
    transition: 0.4s ease;
    }

    .modal-content:hover {
    box-shadow: 0 0 12px #c69ff5, 0 0 25px rgba(198, 159, 245, 0.5);
    border-color: #c69ff5;
    }

    .modal-header {
    background-color: #bfa2db;
    color: white;
    border-radius: 1rem 1rem 0 0;
    box-shadow: inset 0 -2px 4px rgba(255, 255, 255, 0.2);
    }

    .modal-footer {
    border-top: 1px solid #e0cfe9;
    }

    .btn-close {
    background-color: #fff;
    border-radius: 50%;
    padding: 0.5rem;
    }

    .modal.fade .modal-dialog {
    transform: translateY(20px);
    opacity: 0;
    transition: all 0.4s ease-out;
    }

    .modal.fade.show .modal-dialog {
    transform: translateY(0);
    opacity: 1;
    }

    /* ========== TABLES ========== */
    table.table {
    font-size: 0.95rem;
    border-radius: 0.75rem;
    overflow: hidden;
    }

    table thead {
    background-color: #dbc4f0;
    color: #4b306a;
    border-bottom: 2px solid #c69ff5;
    box-shadow: inset 0 -1px 0 #c69ff5;
    }

    table tbody tr:hover {
    background-color: #f0eaff;
    }

    /* ========== BUTTON HOVER NEON ========== */
    .btn.btn-primary:hover {
    background-color: #a173d6;
    box-shadow: 0 0 8px #c69ff5;
    }

    /* ========== ANIMATIONS ========== */
    @keyframes fadeInCard {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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
                    <div class="icon-badge bg-gradient-lilac me-3"><i class="bi bi-box-seam"></i></div>
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
                    <div class="icon-badge bg-gradient-indigo me-3"><i class="bi bi-stack"></i></div>
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
                    <div class="icon-badge bg-gradient-softpink"><i class="bi bi-receipt"></i></div>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="col">
            <div class="card dashboard-card p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="icon-badge bg-gradient-magenta me-3"><i class="bi bi-cash-stack"></i></div>
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
<div class="modal fade" id="stokModal" tabindex="-1" aria-labelledby="stokModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content card-tambah-transaksi">
      <div class="card-header">
        <h5 id="stokModalLabel" class="fw-semibold">
          <i class="bi bi-exclamation-triangle-fill me-2 text-warning"></i> Produk dengan Stok Rendah
        </h5>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-borderless align-middle mb-0">
            <thead>
              <tr style="color: var(--text-dark); border-bottom: 1px solid var(--lilac-muted);">
                <th>Nama Produk</th>
                <th class="text-center">Stok</th>
              </tr>
            </thead>
            <tbody>
              <?php $stok_rendah_q->data_seek(0); while ($row = $stok_rendah_q->fetch_assoc()): ?>
              <tr class="glow-neon">
                <td><?= $row['nama_brg'] ?></td>
                <td class="text-center">
                  <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-semibold">
                    <?= $row['stok'] ?> pcs
                  </span>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer d-flex justify-content-end pt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 0.75rem;">Tutup</button>
      </div>
    </div>
  </div>
</div>

