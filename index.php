<?php
include "koneksi.php";
include 'navbar.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/logo2.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <title>Lilac Store</title>
    <style>
        /* SUNSCREEN STYLE – inverted version */
        .btn-animated-inverse {
            border-radius: 2rem;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
            background-color: rgb(174, 176, 244);
            color: #FFFFFF;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 rgba(255, 255, 255, 0.2);
        }

        .btn-animated-inverse:hover {
            transform: translateY(-3px);
            background-color: #fffFFF;
            color: #rgb(174, 176, 244) !important;
            box-shadow: 0 0 15px 4px rgb(208, 209, 252);
            border-color: transparent;
        }
        
        /* MICELLAR WATER STYLE (already good) */
        .btn-animated {
            border-radius: 2rem;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 0 0 rgba(162, 139, 212, 0.5);
            border: 2px solid #a28bd4;
            color: #a28bd4;
            background-color: transparent;
        }

        .btn-animated:hover {
            transform: translateY(-3px);
            background-color: #a28bd4;
            color: #ffffff !important;
            box-shadow: 0 0 15px 4px rgba(162, 139, 212, 0.7);
            border-color: transparent;
        }
    </style>
</head>

<body>
    <!-- CAROUSEL -->
    <section id="gallery">
        <div id="carouselExample" class="carousel slide carousel-custom mx-auto">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/caro9.webp" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="img/caro10.png" class="d-block w-100" alt="...">
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
                <img src="img/LOGO_LILAC.png" class="img-fluid" width="400" alt="Hero Image">
                <div>
                    <h1 class="fw-bold display-4">💜 Lilac Store</h1>
                    <h4 class="lead-bold display-7">Your Everyday Skincare Bestie to Glow Naturally</h4>
                    <p>
                        Welcome to <strong>Lilac Store</strong>, your go-to space for sensitive-friendly skincare and radiant self-love.  
                        Karena kami percaya, kulit yang sehat bukan hanya tentang tampilan, tapi juga tentang rasa nyaman dan percaya diri.  
                        Mulai hari ini, manjakan kulitmu dengan rangkaian produk aman, lembut, dan penuh cinta.  
                        🌸 Let’s glow together! karena kulitmu pantas untuk diperlakukan istimewa!
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- DISPLAY PRODUCT -->
    <section id="article" class="text-center p-5" style="scroll-margin-top: 50px;">
        <div class="container">
            <h2 class="fw-bold display-4 pb-3">Our Product💜</h2>
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

    <!-- PRODUCT SUNSCREEN -->
    <section class="py-5" style="background-color:rgb(174, 176, 244);">
        <div class="container">
            <div class="row align-items-center g-5">
            <!-- Deskripsi -->
            <div class="col-md-6">
                <h2 class="fw-bold text-uppercase" style="color:rgb(0, 0, 0);">TRIPLE CARE SUNSCREEN</h2>
                <h5 class="fw-bold text-dark">SPF 40 PA+++</h5>
                <p style="color: rgb(0, 0, 0);">
                Diformulasikan dengan <strong>HYBRID formulation</strong> yang menggabungkan UV Filters tipe physical dan chemical
                untuk perlindungan maksimal dari sinar UV 🌞. 
                <br><br>
                Tidak hanya 1, tapi 3 manfaat sekaligus! ✨
                </p>
                <ul style="color: rgb(0, 0, 0);">
                <li>🌿 Perlindungan UV A, UV B & Blue Light</li>
                <li>💧 Mencerahkan: Niacinamide, White Ten™, Tranexamic Acid</li>
                </ul>
                <p style="color:rgb(0, 0, 0);">
                Cocok untuk semua jenis kulit, termasuk kulit sensitif. 
                Yuk cobain sekarang!
                </p>
                <a href="#article" class="btn btn-animated-inverse">Lihat Produk Lainnya</a>
            </div>

            <!-- Gambar -->
            <div class="col-md-6 text-center">
                <img src="img/sunscreen.svg" class="img-fluid rounded-4" alt="Triple Care Sunscreen">
            </div>
            </div>
        </div>
    </section>
    <!--PRODUCT SUNSCREEN END -->

    <!-- PRODUCT MICELLAR WATER -->
    <section class="py-5" style="background-color:rgb(255, 255, 255);">
        <div class="container">
            <div class="row align-items-center g-5">
            <!-- Deskripsi -->
            <div class="col-md-6">
                <h2 class="fw-bold text-uppercase" style="color: #6d4d94;">Micellar Water</h2>
                <h5 class="fw-bold text-dark">With Salicylic Acid</h5>
                <p style="color: #5c5270;">
                Diformulasikan dengan <strong>HYBRID formulation</strong>
                Freindly for acne & only skin 🌞. 
                </p>
                <ul style="color: #6d5d92;">
                <li>💧 Ekstrak bunga calendula, panthenol, dan Hyalumagic 4D</li>
                <li> Terdapat Salicylic acid, Centella asiatica, Witch Hazel, dan Tea Tree Oil 
                    yang memiliki manfaat anti-inflamasi dan membantu menenangkan kulit yang teriritasi 
                    atau meradang, serta membersihkan kotoran minyak</li>
                </ul>
                <p style="color: #5c5270;">
                Cocok untuk semua jenis kulit, termasuk kulit sensitif. 
                Yuk cobain sekarang!
                </p>
                <a href="#article" class="btn btn-animated">Lihat Produk Lainnya</a>
            </div>

            <!-- Gambar -->
            <div class="col-md-6 text-center">
                <img src="img/Micellar_water.svg" class="img-fluid rounded-4" alt="Triple Care Sunscreen">
            </div>
            </div>
        </div>
    </section>
    <!--PRODUCT SUNSCREEN END -->

    <!-- FOOTER -->
    <footer class="text-center text-lg-start text-dark" style="background-color: rgb(174, 176, 244);">
        <section>
            <div class="container text-center text-md-start mt-5">
                <div class="row mt-3">
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4"><br>
                        <h6 class="text-uppercase fw-bold">About Us</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color:rgb(255, 255, 255); height: 2px" />
                        <p>Lilac Store adalah brand lokal yang berkomitmen menghadirkan produk 
                            skincare terbaik untuk kulit sehat dan glowing. </p>
                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4"><br>
                        <h6 class="text-uppercase fw-bold">Contact</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color:rgb(255, 255, 255); height: 2px" />
                        <p><i class="bi bi-house-door-fill"></i> Semarang, Jawa Tengah</p>
                        <p><i class="bi bi-envelope-fill"></i> lilacstore@gmail.com</p>
                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4"><br>
                        <h6 class="text-uppercase fw-bold">Follow Us</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color:rgb(255, 255, 255); height: 2px" />
                        <p>
                            <a href="https://www.instagram.com/jhnaoktv_?igsh=ZmprcGJ2OHJmZTA4" class="text-dark me-4"><i class="bi bi-instagram"></i></a>
                            <a href="0897567889" class="text-dark me-4"><i class="bi bi-telephone-fill"></i></a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <br>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            © 2025 Dibuat oleh <strong>Lilac Store</strong> – Teman Setia Skincare To Glow💜
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>
</html>
