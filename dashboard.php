<?php
    include "koneksi.php"; 

    // Query untuk mengambil data produk dari tbl_stok
    $sql1 = "SELECT * FROM tbl_stok ORDER BY tanggal DESC";
    $hasil1 = $conn->query($sql1);

    // Menghitung jumlah produk
    $jumlah_stok = $hasil1->num_rows;

    // Query untuk mengambil data transaksi dari tbl_transaksi
    $sql2 = "SELECT * FROM tbl_transaksi ORDER BY tgl_trans DESC";
    $hasil2 = $conn->query($sql2);

    // Menghitung jumlah transaksi
    $jumlah_transaksi = $hasil2->num_rows;
?>

<!-- TAMPILAN DASHBOARD -->
<div class="container pt-4">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">
        <!-- Kartu Produk -->
        <div class="col">
            <div class="card shadow-lg border-0 rounded-3 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-box-seam fs-2 text-danger me-3"></i>
                            <h5 class="card-title mb-0">Produk</h5>
                        </div>
                        <div>
                            <span class="badge rounded-pill bg-danger fs-3"><?php echo $jumlah_stok; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

        <!-- Kartu Transaksi -->
        <div class="col">
            <div class="card shadow-lg border-0 rounded-3 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-receipt fs-2 text-success me-3"></i>
                            <h5 class="card-title mb-0">Transaksi</h5>
                        </div>
                        <div>
                            <span class="badge rounded-pill bg-success fs-3"><?php echo $jumlah_transaksi; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
