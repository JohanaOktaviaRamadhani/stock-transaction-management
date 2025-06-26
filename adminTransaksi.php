<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "koneksi.php";

// Cek sesi login admin
if (!isset($_SESSION['id']) || !isset($_SESSION['nama_admin'])) {
    echo "<script>alert('Session expired. Silakan login ulang.'); location.href='login.php';</script>";
    exit;
}

// SIMPAN TRANSAKSI
if (isset($_POST['simpan'])) {
    $tgl = date("Y-m-d H:i:s");
    $id_admin = $_POST['id_admin'];
    $nama_admin = $_POST['nama_admin'];
    $id_brg = $_POST['id_brg'];
    $nama_brg = $_POST['nama_brg'];
    $harga = floatval($_POST['harga']);
    $jumlah = intval($_POST['jml_jual']);
    $subtotal = $harga * $jumlah;

    if ($id_admin && $id_brg && $nama_brg && $harga > 0 && $jumlah > 0) {
        // VALIDASI STOK
        $cekStok = $conn->prepare("SELECT stok FROM tbl_stok WHERE id_brg = ?");
        $cekStok->bind_param("i", $id_brg);
        $cekStok->execute();
        $cekStok->bind_result($stokTersedia);
        $cekStok->fetch();
        $cekStok->close();

        if ($stokTersedia < $jumlah) {
            echo "<script>alert('Stok tidak mencukupi. Maksimal tersedia: $stokTersedia'); history.back();</script>";
            exit;
        }

        // INSERT
        $sql = "CALL insert_transaksi(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siisdii", $tgl, $id_admin, $id_brg, $nama_brg, $harga, $jumlah, $subtotal);
        $stmt->execute();
        echo "<script>alert('Transaksi berhasil ditambahkan'); location.href='admin.php?page=adminTransaksi';</script>";
    }
}

// UPDATE 
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $id_brg = $_POST['id_brg'];
    $nama_brg = $_POST['nama_brg'];
    $harga = floatval($_POST['harga']);
    $jumlah = intval($_POST['jml_jual']);
    $subtotal = $harga * $jumlah;

    if ($id && $id_brg && $nama_brg && $harga > 0 && $jumlah > 0) {
        $sql = "CALL update_transaksi(?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisdii", $id, $id_brg, $nama_brg, $harga, $jumlah, $subtotal);
        $stmt->execute();
        echo "<script>alert('Transaksi berhasil diperbarui'); location.href='admin.php?page=adminTransaksi';</script>";
    }
}

// HAPUS TRANSAKSI
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    if ($id) {
        $sql = "CALL delete_transaksi(?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo "<script>alert('Transaksi berhasil dihapus'); location.href='admin.php?page=adminTransaksi';</script>";
    }
}
?>


<div class="container py-4">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Transaksi
    </button>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Admin</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = $conn->query("SELECT * FROM tbl_transaksi ORDER BY tgl_trans DESC");
                $no = 1;
                while ($row = $q->fetch_assoc()) :
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['tgl_trans'] ?></td>
                    <td><?= $row['id_admin'] ?></td>
                    <td><?= $row['nama_brg'] ?></td>
                    <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                    <td><?= $row['jml_jual'] ?></td>
                    <td>Rp<?= number_format($row['subtotal'], 0, ',', '.') ?></td>
                    <td>
                        <a href="#" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id_trans'] ?>">Edit</a>
                        <a href="#" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id_trans'] ?>">Hapus</a>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit<?= $row['id_trans'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $row['id_trans'] ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Transaksi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label>Nama Barang</label>
                                        <select name="nama_brg" class="form-select" onchange="fillBarangEdit(this, <?= $row['id_trans'] ?>)">
                                            <option value="">-- Pilih Barang --</option>
                                            <?php
                                            $barang = $conn->query("SELECT id_brg, nama_brg, harga FROM tbl_stok");
                                            while ($b = $barang->fetch_assoc()) {
                                                $selected = ($b['id_brg'] == $row['id_brg']) ? 'selected' : '';
                                            ?>
                                            <option 
                                                value="<?= htmlspecialchars($b['nama_brg']) ?>" 
                                                data-id="<?= $b['id_brg'] ?>" 
                                                data-harga="<?= $b['harga'] ?>" 
                                                <?= $selected ?>>
                                                <?= $b['nama_brg'] ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="id_brg" id="id_brg_edit_<?= $row['id_trans'] ?>" value="<?= $row['id_brg'] ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label>Harga</label>
                                        <input type="number" name="harga" id="harga_edit_<?= $row['id_trans'] ?>" class="form-control" value="<?= $row['harga'] ?>" readonly>
                                    </div>
                                    <div class="mb-2">
                                        <label>Jumlah Jual</label>
                                        <input type="number" name="jml_jual" id="jml_edit_<?= $row['id_trans'] ?>" class="form-control" value="<?= $row['jml_jual'] ?>" oninput="hitungSubtotalEdit(<?= $row['id_trans'] ?>)">
                                    </div>
                                    <div class="mb-2">
                                        <label>Subtotal</label>
                                        <input type="number" name="subtotal" id="subtotal_edit_<?= $row['id_trans'] ?>" class="form-control" value="<?= $row['subtotal'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" name="update" class="btn btn-success">Update</button>
                                  <button type="reset" class="btn btn-warning">Reset</button>
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Hapus -->
                <div class="modal fade" id="modalHapus<?= $row['id_trans'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $row['id_trans'] ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Hapus Transaksi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah yakin ingin menghapus <strong><?= $row['nama_brg'] ?></strong> sebanyak <strong><?= $row['jml_jual'] ?></strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_admin" value="<?= $_SESSION['id'] ?>">
                    <div class="mb-2">
                        <label>Nama Admin</label>
                        <input type="text" name="nama_admin" class="form-control" value="<?= $_SESSION['nama_admin'] ?>" readonly>
                    </div>
                    <div class="mb-2">
                        <label>Nama Barang</label>
                        <select name="nama_brg" id="nama_brg" class="form-select" onchange="fillBarang(this)">
                            <option value="">-- Pilih Barang --</option>
                            <?php
                            $barang = $conn->query("SELECT id_brg, nama_brg, harga FROM tbl_stok");
                            while ($b = $barang->fetch_assoc()) {
                            ?>
                            <option value="<?= htmlspecialchars($b['nama_brg']) ?>" data-id="<?= $b['id_brg'] ?>" data-harga="<?= $b['harga'] ?>">
                                <?= $b['nama_brg'] ?>
                            </option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="id_brg" id="id_brg">
                    </div>
                    <div class="mb-2">
                        <label>Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" readonly>
                    </div>
                    <div class="mb-2">
                        <label>Jumlah Pembelian</label>
                        <input type="number" name="jml_jual" id="jml_jual" class="form-control" oninput="hitungSubtotal()">
                    </div>
                    <div class="mb-2">
                        <label>Subtotal</label>
                        <input type="number" name="subtotal" id="subtotal" class="form-control" readonly>
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

<!-- JavaScript -->
<script>
  function fillBarang(select) {
    const harga = select.options[select.selectedIndex].dataset.harga || '';
    const idBrg = select.options[select.selectedIndex].dataset.id || '';
    document.getElementById('harga').value = harga;
    document.getElementById('id_brg').value = idBrg;
    hitungSubtotal();
}

  function hitungSubtotal() {
      const harga = parseFloat(document.getElementById('harga').value) || 0;
      const jumlah = parseInt(document.getElementById('jml_jual').value) || 0;
      document.getElementById('subtotal').value = harga * jumlah;
  }

  function fillBarangEdit(select, id) {
      const harga = select.options[select.selectedIndex].dataset.harga || '';
      const idBrg = select.options[select.selectedIndex].dataset.id || '';
      document.getElementById('harga_edit_' + id).value = harga;
      document.getElementById('id_brg_edit_' + id).value = idBrg;
      hitungSubtotalEdit(id);
  }

  function hitungSubtotalEdit(id) {
      const harga = parseFloat(document.getElementById('harga_edit_' + id).value) || 0;
      const jumlah = parseInt(document.getElementById('jml_edit_' + id).value) || 0;
      document.getElementById('subtotal_edit_' + id).value = harga * jumlah;
  }

  // Reset modalTambah saat dibuka (bersihkan semua input/kembali ke default)
  document.addEventListener('DOMContentLoaded', function () {
    const modalTambah = document.getElementById('modalTambah');
    if (modalTambah) {
        modalTambah.addEventListener('show.bs.modal', function () {
            const form = modalTambah.querySelector('form');
            form.reset();

            document.getElementById('id_brg').value = '';
            document.getElementById('harga').value = '';
            document.getElementById('subtotal').value = '';
        });
    }
});
</script>
