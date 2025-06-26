<?php
session_start();
include "koneksi.php";

// Cek apakah sudah login, jangan redirect ke admin.php kalau admin.php redirect balik ke login.php
if (isset($_SESSION['nama_admin'])) {
    // optional: cek validitas session di database jika mau lebih aman
    header("location:admin.php");
    exit;
}

$error_message = "";

// Cek jika ada request POST untuk login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama_admin = $_POST['user'];
    $password = md5($_POST['pass']); // ⚠️ FYI: untuk production, ganti dengan password_hash & password_verify

    $stmt = $conn->prepare("SELECT id, nama_admin, password FROM tbl_admin WHERE nama_admin = ? AND password = ?");
    $stmt->bind_param("ss", $nama_admin, $password);
    $stmt->execute();
    $hasil = $stmt->get_result();
    $row = $hasil->fetch_assoc();

    if (!empty($row)) {
        // Set session dan redirect ke admin
        $_SESSION['id'] = $row['id'];
        $_SESSION['nama_admin'] = $row['nama_admin'];

        // Redirect hanya saat login sukses
        header("location:admin.php");
        exit;
    } else {
        $error_message = "Invalid username or password. Please try again.";
    }

    $stmt->close();
    $conn->close();
}
?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
            <title>Login | Daily Journal</title>
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background-color: #1c1c1e; 
                }

                .container {
                    width: 100%;
                    max-width: 800px;
                    height: 500px;
                    display: flex;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                }

                .image-container {
                    flex: 1;
                    background: url('img/login.jpg') no-repeat center center;
                    background-size: cover;
                }

                .form-container {
                    flex: 1;
                    padding: 30px;
                    background: linear-gradient(135deg, #4e54c8, #8f94fb); 
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                }

                .form-title {
                    font-size: 24px;
                    font-weight: bold;
                    color: #ffffff;
                    text-align: center;
                    margin-bottom: 20px;
                }

                .form-container p {
                    text-align: center;
                    color: #d1d1d1;
                    margin-bottom: 30px;
                }

                .form-control {
                    background-color: rgba(255, 255, 255, 0.1);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                    border-radius: 8px;
                    padding: 12px 15px;
                    color: #ffffff;
                }

                .form-control:focus {
                    background-color: rgba(255, 255, 255, 0.2);
                    border-color: #ffffff;
                    color: #ffffff;
                    outline: none;
                    box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
                }

                .btn-primary {
                    background: linear-gradient(135deg, #4caf50, #81c784); 
                    border: none;
                    border-radius: 8px;
                    padding: 10px 15px;
                    color: #ffffff;
                    font-size: 16px;
                    font-weight: bold;
                    transition: all 0.3s ease-in-out;
                }

                .btn-primary:hover {
                    transform: scale(1.05);
                    background: linear-gradient(135deg, #388e3c, #66bb6a);
                }

                .btn-secondary {
                    background-color: transparent;
                    color: #ffffff;
                    border: 1px solid rgba(255, 255, 255, 0.5);
                    border-radius: 8px;
                    padding: 10px 15px;
                    font-size: 14px;
                    transition: all 0.3s ease-in-out;
                }

                .btn-secondary:hover {
                    background-color: rgba(255, 255, 255, 0.1);
                    transform: scale(1.05);
                }

                .form-text {
                    font-size: 12px;
                    color: rgba(255, 255, 255, 0.7);
                }

                .alert {
                    max-width: 100%; 
                    width: 100%; /
                    margin: 10px auto; 
                    font-size: 14px; 
                    padding: 10px 15px; 
                    border-radius: 8px; 
                }


                @media (max-width: 768px) {
                    .container {
                        flex-direction: column;
                        height: auto;
                    }
                    .image-container {
                        height: 200px;
                    }
                    .form-container {
                        padding: 20px;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <!-- Gambar -->
                <div class="image-container"></div>

                <!-- Formulir -->
                <div class="form-container">
                    <div class="form-title">Welcome Back!</div>
                    <p>Please log in to access your account</p>

                    <!-- PESAN JIKA SALAH USERNAME / PW  -->
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger text-center">
                            <?= $error_message ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label text-white">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-white"><i class="bi bi-person"></i></span>
                                <input type="text" name="user" class="form-control" id="username" placeholder="Enter your username">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-white">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent text-white"><i class="bi bi-lock"></i></span>
                                <input type="password" name="pass" class="form-control" id="password" placeholder="Enter your password">
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Login</button>
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        </body>
    </html>

