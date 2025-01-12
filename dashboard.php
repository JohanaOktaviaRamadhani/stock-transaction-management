<?php
    include "koneksi.php"; 
    // Query untuk mengambil data artikel
    $sql1 = "SELECT * FROM article ORDER BY tanggal DESC";
    $hasil1 = $conn->query($sql1);

    // Menghitung jumlah baris data artikel
    $jumlah_article = $hasil1->num_rows;

    // Query untuk mengambil data gallery
    $sql2 = "SELECT * FROM tbl_gallery ORDER BY tanggal DESC";
    $hasil2 = $conn->query($sql2);

    // Menghitung jumlah baris data gallery
    $jumlah_gallery = $hasil2->num_rows;
?>

<!-- TAMPILAN DASHBOARD -->
<div class="container pt-4">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">
        <div class="col">
            <div class="card shadow-lg border-0 rounded-3 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-newspaper fs-2 text-danger me-3"></i>
                            <h5 class="card-title mb-0">Article</h5>
                        </div>
                        <div>
                            <span class="badge rounded-pill bg-danger fs-3"><?php echo $jumlah_article; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col">
            <div class="card shadow-lg border-0 rounded-3 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-camera fs-2 text-danger me-3"></i>
                            <h5 class="card-title mb-0">Gallery</h5>
                        </div>
                        <div>
                            <span class="badge rounded-pill bg-danger fs-3"><?php echo $jumlah_gallery; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>