<?php
include "koneksi.php";
include 'navbar.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/LOGO-DAILY.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Web Daily Johana</title>
</head>

<body>
    <!-- CAROUSEL -->
    <section id="gallery">
        <div id="carouselExample" class="carousel slide carousel-custom mx-auto">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/caro2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="img/caro1.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <br>

    <!-- HEADER -->
    <section id="hero" class="text-sm-start">
        <div class="container">
            <div class="d-sm-flex flex-sm-row-reverse align-items-center">
                <img src="img/LOGO-DAILY.png" class="img-fluid" width="400" alt="Hero Image">
                <div>
                    <h1 class="fw-bold display-4">Daily Website</h1>
                    <h4 class="lead-bold display-7">Selamat datang di Daily Website – Teman Setia Hari Anda!</h4>
                    <p>
                        Saya Johana Oktavia Ramadhani, mahasiswi Teknik Informatika di Universitas Dian Nuswantoro. Website ini saya buat untuk berbagi artikel, ide-ide menarik, dan inspirasi visual yang bisa kamu nikmati setiap hari.
                        <br>Yuk, jelajahi dan temukan hal-hal baru di sini.
                    </p>
                    <h6 style="color: #7c4dff;">
                        <span id="tanggal"></span>
                        <span id="jam"></span>
                    </h6>
                </div>
            </div>
        </div>
    </section>

    <!-- DISPLAY PRODUCT -->
    <section id="article" class="text-center p-5">
        <div class="container">
            <h2 class="fw-bold display-4 pb-3">Our Product</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php
                $sql = "SELECT * FROM tbl_stok ORDER BY tanggal DESC";
                $hasil = $conn->query($sql); 

                while($row = $hasil->fetch_assoc()){
                ?>
                    <div class="col">
                        <div class="card h-100 border-0"
                            style="background: linear-gradient(to bottom right, #eae6fc, #f8f4ff); 
                                    border-radius: 1rem; 
                                    transition: box-shadow 0.3s ease-in-out;
                                    box-shadow: 0 0 0 rgba(162, 139, 212, 0.5);"
                            onmouseover="this.style.boxShadow='0 0 15px 3px rgba(162,139,212,0.75)'"
                            onmouseout="this.style.boxShadow='0 0 0 rgba(162, 139, 212, 0.5)'">

                            <img src="img/<?= $row["gambar"] ?>" class="card-img-top" alt="<?= $row["nama_brg"] ?>"
                                style="width: 100%; aspect-ratio: 1 / 1; object-fit: cover; border-top-left-radius: 1rem; border-top-right-radius: 1rem;" />
                            <div class="card-body text-start" style="color: #5c5270;">
                                <h5 class="card-title fw-bold" style="color: #4b3f72;">
                                    <?= $row["nama_brg"] ?>
                                </h5>
                                <p class="card-text small" style="color: #6d5d92;">
                                    <?= substr(strip_tags($row["deskripsi"]), 0, 100) ?>...
                                </p>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center border-0"
                                style="background-color: #f0eaff; border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem;">
                                <span class="fw-bold" style="color: #4caf50;">
                                    Rp<?= number_format($row["harga"] ?? 0, 0, ',', '.') ?>
                                </span>
                                <span style="background-color: <?= ($row["stok"] > 0) ? '#a28bd4' : '#c4b5d9' ?>;
                                              color: #ffffff;
                                              font-weight: 500;
                                              padding: 6px 12px;
                                              border-radius: 999px;
                                              font-size: 0.85rem;">
                                    <?= ($row["stok"] > 0) ? 'Stok: '.$row["stok"] : 'Stok Habis' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php } ?> 
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="text-center text-lg-start text-white" style="background-color: #472e8d">
        <section>
            <div class="container text-center text-md-start mt-5">
                <div class="row mt-3">
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4"><br>
                        <h6 class="text-uppercase fw-bold">About Me</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p>Saya Johana Oktavia Ramadhani, mahasiswi Teknik Informatika di Universitas Dian Nuswantoro.</p>
                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4"><br>
                        <h6 class="text-uppercase fw-bold">Contact Me</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p><i class="bi bi-house-door-fill"></i> Semarang, Jawa Tengah</p>
                        <p><i class="bi bi-envelope-fill"></i> hanaoktavia82281@gmail.com</p>
                        <p><i class="bi bi-phone-fill"></i> 089661235659</p>
                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4"><br>
                        <h6 class="text-uppercase fw-bold">Follow Me</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p>
                            <a href="https://www.instagram.com/jhnaoktv_?igsh=ZmprcGJ2OHJmZTA4" class="text-white me-4"><i class="bi bi-instagram"></i></a>
                            <a href="https://www.linkedin.com/in/johanaoktavia" class="text-white me-4"><i class="bi bi-linkedin"></i></a>
                            <a href="https://github.com/JohanaOktaviaRamadhani" class="text-white me-4"><i class="bi bi-github"></i></a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <br>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            © 2024 Dibuat oleh Johana Oktavia Ramadhani - A11.2023.15024
        </div>
    </footer>

    <script>
        window.setTimeout("tampilWaktu()", 1000);
        function tampilWaktu() {
            var waktu = new Date();
            var bulan = waktu.getMonth() + 1;
            setTimeout("tampilWaktu()", 1000);
            document.getElementById("tanggal").innerHTML =
                waktu.getDate() + "/" + bulan + "/" + waktu.getFullYear();
            document.getElementById("jam").innerHTML =
                waktu.getHours() + ":" + waktu.getMinutes() + ":" + waktu.getSeconds();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>
</html>
