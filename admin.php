<?php
session_start();
if (!isset($_SESSION['nama_admin'])) {
    header("location:login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lilac Shop</title>
    <link rel="icon" href="img/logo.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        /* ===== RESET DAN DASAR ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body, html {
            height: 100%;
            background-color: #fdfaff;
            display: flex;
            flex-direction: column;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background: linear-gradient(90deg, #6B46C1, #6B46C1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.5px;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
            padding: 8px 15px;
            transition: color 0.3s, transform 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: #FEEBCB !important;
            transform: translateY(-2px);
        }

        .navbar-toggler {
            border-color: #fff;
        }

        /* ===== DROPDOWN ===== */
        .dropdown-menu {
            background-color: #B794F4;
            border: none;
            border-radius: 8px;
            padding: 0;
            z-index: 1050;
        }

        .dropdown-item {
            color: #fff;
            font-weight: 500;
            padding: 10px 15px;
            transition: background-color 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #F6AD55;
            color: #4A148C;
        }

        /* ===== LOGOUT ITEM ===== */
        .logout-item {
            background-color: #9F7AEA;
            color: #fff;
            border-radius: 6px;
            margin: 5px;
            font-weight: bold;
            text-align: center;
            transition: all 0.3s ease;
        }

        .logout-item:hover {
            background-color: #F6AD55;
            color: #6B46C1;
            cursor: pointer;
        }

        /* ===== MAIN CONTENT ===== */
        main {
            flex: 1;
            padding: 30px;
            background-color: #fff;
        }

        .lead.display-6 {
            color: #1A202C;
            font-weight: 600;
        }

        .border-danger-subtle {
            border-color: #B794F4 !important;
        }

        /* ===== FOOTER ===== */
        .bg-footer {
            background-color: #6B46C1;
            padding: 25px 0;
            color: #fff;
            text-align: center;
            font-size: 0.9rem;
        }

        /* ===== TABLE ===== */
        .table thead {
            background-color: #9F7AEA;
            color: white;
        }

        .table-hover tbody tr:hover {
            background-color: #f3e8ff;
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            background-color: #9F7AEA;
            border: none;
        }

        .btn-primary:hover {
            background-color: #B794F4;
        }

        .btn-success {
            background-color: #68D391;
            border: none;
        }

        .btn-success:hover {
            background-color: #48BB78;
        }

        /* ===== FORM INPUTS ===== */
        input, select, textarea {
            border: 1px solid #D6BCFA;
            border-radius: 6px;
            padding: 8px 12px;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #9F7AEA;
            box-shadow: 0 0 5px rgba(155, 89, 182, 0.5);
            outline: none;
        }

        /* ===== CUSTOM UTILITIES ===== */
        .card-purple {
            border: 1px solid #D6BCFA;
            background: #FAF5FF;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(183, 148, 244, 0.1);
            padding: 20px;
        }
    </style>

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="admin.php?page=dashboard">Lilac Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php?page=dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php?page=stok">Stok</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php?page=adminTransaksi">Transaksi</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                            <?= htmlspecialchars($_SESSION['nama_admin']) ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item logout-item" href="logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1">
        <div class="container">
            <?php
            $allowed_pages = ['dashboard', 'stok', 'adminTransaksi'];
            $currentPage = $_GET['page'] ?? 'dashboard';

            if (in_array($currentPage, $allowed_pages)) {
                $pageTitle = match ($currentPage) {
                    'stok' => 'Stok Produk',
                    'adminTransaksi' => 'Manajemen Transaksi',
                    default => ucfirst($currentPage)
                };
                echo "<h4 class='lead display-6 pb-2 border-bottom border-danger-subtle'>$pageTitle</h4>";
                include("$currentPage.php");
            } else {
                echo "<h4 class='lead display-6 pb-2 border-bottom border-danger-subtle'>Dashboard</h4>";
                include("dashboard.php");
            }
            ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-footer text-center text-white">
        © 2025 Inventory for Lilac Store - by Johana and Chalida and Megan
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
