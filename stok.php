<!-- HTML + MODAL -->
<div class="container">
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#IdModal">
        <i class="bi bi-plus-lg"></i> Tambah Product
    </button>

    <div class="row">
        <div class="table-responsive" id="stok_data"></div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="IdModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" name="nama_brg" placeholder="Nama Produk" required>
                            </div>
                            <div class="mb-3">
                                <label>Deskripsi</label>
                                <textarea class="form-control" placeholder="Tuliskan Deskripsi Produk" name="deskripsi" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" class="form-control" name="harga" placeholder="Masukkan Harga" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" class="form-control" name="stok" placeholder="Jumlah Stok" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="gambar">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AJAX Script -->
<script>
$(document).ready(function() {
    load_data();

    function load_data(hlm) {
        $.ajax({
            url: "stok_data.php",
            method: "POST",
            data: { hlm: hlm },
            success: function(data) {
                $('#stok_data').html(data);
            }
        });
    }

    $(document).on('click', '.halaman', function() {
        var hlm = $(this).attr("id");
        load_data(hlm);
    });
});
</script>

<!-- PHP Script -->
<?php
include "upload_foto.php";
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $nama_brg   = $_POST['nama_brg'];
    $deskripsi  = $_POST['deskripsi'];
    $harga      = $_POST['harga'];
    $stok       = $_POST['stok'];
    $isi        = ''; // default kosong, jika tidak dipakai
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