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
            <thead class="thead-lilac">
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
                        <div class="d-flex gap-2">
                          <a href="#" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id_trans'] ?>">Edit</a>
                          <a href="#" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id_trans'] ?>">Hapus</a>
                        </div>
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

  // Reset di modalTambah 
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

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet" />

<style>
  :root {
    --lilac-gradient-start: #eae6fc;
    --lilac-gradient-end: #f8f4ff;
    --lilac-shadow: rgba(162, 139, 212, 0.75);
    --lilac-primary: #a28bd4;
    --lilac-muted: #c4b5d9;
    --text-dark: #3e2d64;
    --text-muted: #6d5d92;
    --bg-footer: #f0eaff;
    --table-hover: rgba(226, 215, 255, 0.6);
    --table-stripe: #f7f1ff;
  }

  body {
    background-color: var(--lilac-gradient-end);
    font-family: 'Quicksand', sans-serif;
    color: var(--text-dark);
  }

  /* Table */
  .table {
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(162, 139, 212, 0.1);
    animation: fadeInTable 0.6s ease;
    background-color: white;
    border-collapse: separate;
    border-spacing: 0;
  }

  .table .badge {
  padding: 0.5rem 0.75rem;
  font-size: 0.85rem;
  border-radius: 0.5rem;
  text-decoration: none;
  display: inline-block;
}

.d-flex.gap-2 {
  gap: 0.5rem;
}

  .thead-lilac {
    background-color: var(--lilac-primary) !important;
  }

  .thead-lilac th {
    background-color: var(--lilac-primary) !important;
    color: black !important;
    font-weight: 700;
    font-size: 1.05rem; /* Tambahkan atau sesuaikan ukuran font di sini */
    text-transform: capitalize;
    letter-spacing: 0.5px;
  }


  .table th,
  .table td {
    padding: 0.85rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #ddd;
    color: var(--text-dark);
    font-size: 0.95rem;
    white-space: nowrap; 
  }
  .table td:nth-child(4) {
    text-align: left; 
    max-width: 300px;
    white-space: normal;
  }
  .table tbody tr:nth-child(even) {
    background-color: var(--table-stripe);
  }

  .table-hover tbody tr {
    transition: all 0.2s ease;
  }

  .table-hover tbody tr:hover {
    background-color: var(--table-hover);
  }

  .table tbody tr {
    animation: fadeInRow 0.4s ease-in-out both;
  }

  @keyframes fadeInRow {
    from {
      opacity: 0;
      transform: translateY(5px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes fadeInTable {
    0% {
      opacity: 0;
      transform: scale(0.97);
    }
    100% {
      opacity: 1;
      transform: scale(1);
    }
  }

  /* Buttons */
  .btn-primary {
    background-color: var(--lilac-primary);
    border: none;
    font-weight: 500;
    transition: all 0.3s ease;
    color: white;
    font-family: 'Quicksand', sans-serif;
  }

  .btn-primary:hover {
    background-color: #8e77c7;
    box-shadow: 0 4px 10px var(--lilac-shadow);
  }

  .btn-warning {
    background-color: #fdd68f;
    border: none;
  }

  .btn-success {
    background-color: #88d6ba;
    border: none;
  }

  .btn-danger {
    background-color: #e79999;
    border: none;
  }

  .btn-secondary {
    background-color: #d3d3e3;
    color: #4b3f72;
    border: none;
  }

  .btn {
    transition: all 0.3s ease-in-out;
  }

  .btn:hover {
    transform: scale(1.04);
  }

  /* Modal */
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

  .modal.fade .modal-dialog {
    transform: translateY(20px);
    opacity: 0;
    transition: all 0.4s ease-out;
  }

  .modal.fade.show .modal-dialog {
    transform: translateY(0);
    opacity: 1;
  }

  /* Form Input */
  input.form-control,
  select.form-select {
    border-radius: 0.75rem;
    border: 1px solid var(--lilac-muted);
    background-color: white;
    font-family: 'Quicksand', sans-serif;
  }

  input.form-control:read-only {
    background-color: #f0eaff;
    pointer-events: none;
    cursor: not-allowed;
    color: #999;
  }

  input.form-control:focus,
  select.form-select:focus {
    border-color: #a28bd4;
    box-shadow: 0 0 0 0.2rem rgba(162, 139, 212, 0.25);
    transition: all 0.3s ease-in-out;
  }

  /* Badge */
  .badge.bg-success {
    background-color: #88d6ba;
    cursor: pointer;
  }

  .badge.bg-danger {
    background-color: #e79999;
    cursor: pointer;
  }

  .badge {
    transition: all 0.3s ease;
    font-family: 'Quicksand', sans-serif;
  }

  .badge:hover {
    transform: scale(1.05);
    opacity: 0.9;
  }

  /* Card Hover */
  .card-effect-hover {
    transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
  }

  .card-effect-hover:hover {
    box-shadow: 0 0 15px 3px rgba(162, 139, 212, 0.75);
    transform: translateY(-5px);
  }
  .table .badge {
    padding: 0.5rem 0.75rem;
    font-size: 0.85rem;
    border-radius: 0.5rem;
    text-decoration: none;
    display: inline-block;
  }

  .d-flex.gap-2 {
    gap: 0.5rem;
  }

</style>


