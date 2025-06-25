<?php
include "koneksi.php";

// SIMPAN TRANSAKSI
if (isset($_POST['simpan'])) {
    $tgl = date("Y-m-d H:i:s");
    $id_admin = $_POST['id_admin'];
    $nama_admin = $_POST['nama_admin'];
    $id_brg = $_POST['id_brg'];
    $nama_brg = $_POST['nama_brg'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jml_jual'];
    $subtotal = $harga * $jumlah;

    $stmt = $conn->prepare("INSERT INTO tbl_transaksi (tgl_trans, id_admin, nama_admin, id_brg, nama_brg, harga, jml_jual, subtotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssii", $tgl, $id_admin, $nama_admin, $id_brg, $nama_brg, $harga, $jumlah, $subtotal);
    $stmt->execute();

    echo "<script>alert('Transaksi berhasil ditambahkan');location.href='admin.php?page=transaksi';</script>";
}

// UPDATE TRANSAKSI
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_brg = $_POST['nama_brg'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jml_jual'];
    $subtotal = $harga * $jumlah;

    $stmt = $conn->prepare("UPDATE tbl_transaksi SET nama_brg=?, harga=?, jml_jual=?, subtotal=? WHERE id_trans=?");
    $stmt->bind_param("siddi", $nama_brg, $harga, $jumlah, $subtotal, $id);
    $stmt->execute();

    echo "<script>alert('Transaksi berhasil diperbarui');location.href='admin.php?page=transaksi';</script>";
}

// HAPUS TRANSAKSI
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM tbl_transaksi WHERE id_trans=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo "<script>alert('Transaksi berhasil dihapus');location.href='admin.php?page=transaksi';</script>";
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
                while ($row = $q->fetch_assoc()) {
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
                            <a href="#" class="badge text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id_trans'] ?>">Edit</a>
                            <a href="#" class="badge text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id_trans'] ?>">Hapus</a>
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
                                            <input type="text" name="nama_brg" class="form-control" value="<?= $row['nama_brg'] ?>" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Harga</label>
                                            <input type="number" name="harga" class="form-control" value="<?= $row['harga'] ?>" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Jumlah Jual</label>
                                            <input type="number" name="jml_jual" class="form-control" value="<?= $row['jml_jual'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="update" class="btn btn-success">Update</button>
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
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah yakin ingin menghapus transaksi <strong><?= $row['nama_brg'] ?></strong> sebanyak <strong><?= $row['jml_jual'] ?></strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>
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
          <div class="mb-2">
            <label>ID Admin</label>
            <input type="text" name="id_admin" id="id_admin" class="form-control" onchange="getAdmin(this.value)" required>
          </div>
          <div class="mb-2">
            <label>Nama Admin</label>
            <input type="text" name="nama_admin" id="nama_admin" class="form-control" readonly>
          </div>
          <div class="mb-2">
            <label>ID Barang</label>
            <input type="text" name="id_brg" id="id_brg" class="form-control" onchange="getBarang(this.value)" required>
          </div>
          <div class="mb-2">
            <label>Nama Barang</label>
            <input type="text" name="nama_brg" id="nama_brg" class="form-control" readonly required>
          </div>
          <div class="mb-2">
            <label>Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" readonly required>
          </div>
          <div class="mb-2">
            <label>Jumlah Pembelian</label>
            <input type="number" name="jml_jual" id="jml_jual" class="form-control" min="1" oninput="hitungSubtotal()" required>
          </div>
          <div class="mb-2">
            <label>Subtotal</label>
            <input type="number" name="subtotal" id="subtotal" class="form-control" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Script AJAX -->
<script>
function getAdmin(id_admin) {
  if (!id_admin) return;
  fetch(`get_admin.php?id=${id_admin}`)
    .then(res => res.json())
    .then(data => {
      document.getElementById('nama_admin').value = data.nama_admin || '';
    })
    .catch(err => console.error(err));
}

function getBarang(id_brg) {
  if (!id_brg) return;
  fetch(`get_barang.php?id=${id_brg}`)
    .then(res => res.json())
    .then(data => {
      document.getElementById('nama_brg').value = data.nama_brg || '';
      document.getElementById('harga').value = data.harga || '';
      hitungSubtotal();
    })
    .catch(err => console.error(err));
}

function hitungSubtotal() {
  const harga = parseFloat(document.getElementById('harga').value) || 0;
  const jumlah = parseInt(document.getElementById('jml_jual').value) || 0;
  document.getElementById('subtotal').value = harga * jumlah;
}
</script>

