<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "koneksi.php";
include "upload_foto.php";

// Cek sesi login admin
if (!isset($_SESSION['id']) || !isset($_SESSION['nama_admin'])) {
    echo "<script>alert('Session expired. Silakan login ulang.'); location.href='login.php';</script>";
    exit;
}

// Simpan Produk
if (isset($_POST['simpan'])) {
    $nama_brg   = $_POST['nama_brg'];
    $deskripsi  = $_POST['deskripsi'];
    $harga      = $_POST['harga'];
    $stok       = $_POST['stok'];
    $isi        = '';
    $tanggal    = date("Y-m-d H:i:s");
    $username   = $_SESSION['nama_admin'];
    $gambar     = '';
    $nama_gambar = $_FILES['gambar']['name'];

    if ($nama_gambar != '') {
        $cek_upload = upload_foto($_FILES["gambar"]);
        if ($cek_upload['status']) {
            $gambar = $cek_upload['message'];
        } else {
            echo "<script>alert('" . $cek_upload['message'] . "');document.location='admin.php?page=stok';</script>";
            die;
        }
    }

    if (isset($_POST['id_brg'])) {
        $id_brg = $_POST['id_brg'];
        if ($nama_gambar == '') {
            $gambar = $_POST['gambar_lama'];
        } else {
            unlink("img/" . $_POST['gambar_lama']);
        }

        $stmt = $conn->prepare("CALL update_stok(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issdidsss", $id_brg, $nama_brg, $deskripsi, $harga, $stok, $isi, $gambar, $tanggal, $username);
        $simpan = $stmt->execute();
    } else {
        $stmt = $conn->prepare("CALL insert_stok(?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdidsss", $nama_brg, $deskripsi, $harga, $stok, $isi, $gambar, $tanggal, $username);
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>alert('Simpan data sukses');document.location='admin.php?page=stok';</script>";
    } else {
        echo "<script>alert('Simpan data gagal');document.location='admin.php?page=stok';</script>";
    }
    $stmt->close();
    $conn->close();
}

// Hapus Produk
if (isset($_POST['hapus'])) {
    $id_brg = $_POST['id_brg'];
    $gambar = $_POST['gambar'];

    if ($gambar != '') {
        unlink("img/" . $gambar);
    }

    $stmt = $conn->prepare("CALL delete_stok(?)");
    $stmt->bind_param("i", $id_brg);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>alert('Hapus data sukses');document.location='admin.php?page=stok';</script>";
    } else {
        echo "<script>alert('Hapus data gagal');document.location='admin.php?page=stok';</script>";
    }
    $stmt->close();
    $conn->close();
}
?>
<!-- BUTTON -->
<div class="container py-4">
  <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
    <i class="bi bi-plus-lg"></i> Tambah Produk
  </button>
  <div class="table-responsive fadeInTable" id="stok_data"></div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
  <div class="modal-dialog">
    <form method="post" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Produk</h5>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label>Nama Produk</label>
            <input type="text" name="nama_brg" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required></textarea>
          </div>
          <div class="mb-2">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
          <button type="reset" class="btn btn-warning">Reset</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- JavaScript Load Data -->
<script>
  $(document).ready(function () {
    load_data();
    function load_data(hlm) {
      $.ajax({
        url: "stok_data.php",
        method: "POST",
        data: { hlm: hlm },
        success: function (data) {
          $('#stok_data').hide().html(data).fadeIn().addClass('fadeInTable');
        }
      });
    }
    $(document).on('click', '.halaman', function () {
      var hlm = $(this).attr("id");
      load_data(hlm);
    });
  });
</script>

<!-- Stylesheet -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
<style>
  :root {
    --lilac-gradient-start: #eae6fc;
    --lilac-gradient-end: #f8f4ff;
    --lilac-shadow: rgba(162, 139, 212, 0.75);
    --lilac-primary: #a28bd4;
    --lilac-muted: #c4b5d9;
    --text-dark: #3e2d64;
  }
  body {
    background-color: var(--lilac-gradient-end);
    font-family: 'Quicksand', sans-serif;
    color: var(--text-dark);
  }
  .form-control {
    resize: none;
  }
  .btn {
    font-family: 'Quicksand', sans-serif;
    transition: all 0.3s ease-in-out;
  }
  .btn-primary {
    background-color: var(--lilac-primary);
    border: none;
    color: white;
    font-weight: 500;
  }
  .btn-primary:hover {
    background-color: #8e77c7;
    box-shadow: 0 4px 10px var(--lilac-shadow);
    transform: scale(1.04);
  }
  .btn-secondary {
    background-color: #d3d3e3;
    color: #4b3f72;
    border: none;
  }
  .btn-secondary:hover {
    transform: scale(1.04);
  }
  .btn-warning {
    background-color: #fdd68f;
    border: none;
    color: black;
  }
  .btn-warning:hover {
    background-color: #fbc968;
    transform: scale(1.04);
    box-shadow: 0 4px 10px rgba(250, 193, 86, 0.4);
  }
  .btn-outline-secondary {
    border: none;
    color: black;
    background-color: #f0eaff;
  }
  .btn-outline-secondary:hover {
    background-color: #e2d6fa;
    transform: scale(1.04);
    box-shadow: 0 4px 10px rgba(198, 159, 245, 0.3);
  }
  .modal-content {
    border-radius: 1rem;
    box-shadow: 0 0 15px var(--lilac-shadow);
    background: linear-gradient(to bottom right, var(--lilac-gradient-start), var(--lilac-gradient-end));
    border: 1px solid var(--lilac-muted);
  }
  .modal-header {
    background-color: var(--lilac-primary);
    color: white;
    border-radius: 1rem 1rem 0 0;
  }
  input.form-control,
  textarea.form-control {
    border-radius: 0.75rem;
    border: 1px solid var(--lilac-muted);
    background-color: white;
  }
  input.form-control:focus,
  textarea.form-control:focus {
    border-color: var(--lilac-primary);
    box-shadow: 0 0 0 0.2rem rgba(162, 139, 212, 0.25);
    transition: all 0.3s ease-in-out;
  }

  /* Fade-in animation */
  .fadeInTable {
    animation: fadeIn 0.5s ease-in-out;
  }
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>
