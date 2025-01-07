<?php
session_start(); // Memulai atau melanjutkan session

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Jika session username tidak ada, redirect ke login.php
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Daily Journal | Admin</title>
    <link rel="icon" href="img/logo.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Tambahkan CSS untuk memperbaiki dropdown menu dan warna -->
    <style>
        html { position: relative; min-height: 100%; }
        body { margin-bottom: 100px; /* Margin bottom by footer height */ }
        footer { position: absolute; bottom: 0; width: 100%; height: 100px; /* Set the fixed height of the footer here */ }

        /* Navbar custom styles */
        .navbar {
            background-color: #6B46C1;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
        }

        .navbar-nav .nav-link:hover {
            color: #F6AD55 !important; /* Hover effect with a complementary color */
        }

        .dropdown-menu {
            background-color: #6B46C1;
            border: none;
            z-index: 1050 !important;
        }

        .dropdown-item {
            color: #fff;
        }

        .dropdown-item:hover {
            background-color: #F6AD55;
        }

        /* Logout button styles */
            .logout-item {
            color: #fff;
            padding: 10px 20px;
            font-weight: bold;
            text-align: center;
            border-top: 1px solid #D85B5B; /* Ganti dengan warna merah muda */
            border-bottom: 1px solid #D85B5B; /* Ganti dengan warna merah muda */
            transition: all 0.3s ease;
        }

        .logout-item:hover {
            background-color: #D85B5B; /* Ganti dengan warna merah muda */
            color: #6B46C1; /* Warna teks kembali ke primary */
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Content */
        #content {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Section title */
        .lead.display-6 {
            color: #1A202C;
        }

        .border-danger-subtle {
            border-color: #6B46C1 !important;
        }

        /* Footer */
        footer {
            background-color: #1A202C;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" target="_blank" href=".">My Daily Journal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php?page=dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php?page=article">Article</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php?page=galleryadmin">Gallery</a>
                    </li> 
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $_SESSION['username'] ?>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Logout item with new design -->
                            <li><a class="dropdown-item logout-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li> 
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <section id="content" class="p-5">
        <div class="container">
            <?php
            if (isset($_GET['page'])) {
                ?>
                <h4 class="lead display-6 pb-2 border-bottom border-danger-subtle"><?= ucfirst($_GET['page']) ?></h4>
                <?php
                include($_GET['page'].".php");
            } else {
                ?>
                <h4 class="lead display-6 pb-2 border-bottom border-danger-subtle">Dashboard</h4>
                <?php
                include("dashboard.php");
            }
            ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; <?= date('Y') ?> My Daily Journal | Dibuat oleh Johana Oktavia Ramadhani - A11.2023.15024</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
