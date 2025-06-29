<?php
include "koneksi.php";

$hlm = $_POST['hlm'] ?? 1;
$limit = 5;
$limit_start = ($hlm - 1) * $limit;
$no = $limit_start + 1;

$sql = "SELECT * FROM tbl_stok 
        ORDER BY tanggal DESC 
        LIMIT $limit_start, $limit";

$hasil = $conn->query($sql);
?>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet" />

<div class="table-responsive">
  <table class="table table-bordered table-hover">

    <thead class="thead-lilac">
      <tr>
        <th>No</th>
        <th>Nama Produk</th>
        <th>Deskripsi</th>
        <th>Gambar</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
      </tr>
    </thead>

    <tbody>
      <?php while ($row = $hasil->fetch_assoc()) : ?>
        <tr>
          <td><?= $no++ ?></td>
          <td>
            <strong><?= $row["nama_brg"] ?></strong><br>
            <small><em><?= $row["tanggal"] ?> by <?= $row["username"] ?></em></small>
          </td>
          <td><?= $row["deskripsi"] ?></td>
          <td>
            <?php if (!empty($row["gambar"]) && file_exists('img/' . $row["gambar"])) : ?>
              <img src="img/<?= $row["gambar"] ?>" width="100">
            <?php else: ?>
              <small class="text-muted">No Image</small>
            <?php endif; ?>
          </td>
          <td>Rp<?= number_format($row["harga"] ?? 0, 0, ',', '.') ?></td>
          <td><?= $row["stok"] ?></td>
          <td>         
            <div class="d-flex gap-2">
              <a href="#" 
                class="badge bg-success text-decoration-none" 
                data-bs-toggle="modal" 
                data-bs-target="#modalEdit<?= $row['id_brg'] ?>" 
                onclick="lockRecord(<?= $row['id_brg'] ?>)">
                Edit
              </a>
              <a href="#" 
                class="badge bg-danger text-decoration-none" 
                data-bs-toggle="modal" 
                data-bs-target="#modalHapus<?= $row['id_brg'] ?>">
                Hapus
              </a>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit<?= $row["id_brg"] ?>" tabindex="-1">
              <div class="modal-dialog">
              <form method="post" enctype="multipart/form-data" onsubmit="return unlockBeforeSubmit(<?= $row['id_brg'] ?>)">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Produk</h5>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="id_brg" value="<?= $row["id_brg"] ?>">
                      <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">

                      <div class="mb-3">
                        <label>Nama Produk</label>
                        <input type="text" class="form-control" name="nama_brg"
                          value="<?= $row["nama_brg"] ?>"
                          data-default="<?= htmlspecialchars($row["nama_brg"], ENT_QUOTES) ?>"
                          required>
                      </div>

                      <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" required
                          data-default="<?= htmlspecialchars($row["deskripsi"], ENT_QUOTES) ?>"><?= $row["deskripsi"] ?></textarea>
                      </div>

                      <div class="mb-3">
                        <label>Harga</label>
                        <input type="number" class="form-control" name="harga"
                          value="<?= $row["harga"] ?>"
                          data-default="<?= $row["harga"] ?>" required>
                      </div>

                      <div class="mb-3">
                        <label>Stok</label>
                        <input type="number" class="form-control" name="stok"
                          value="<?= $row["stok"] ?>"
                          data-default="<?= $row["stok"] ?>" required>
                      </div>

                      <div class="mb-3">
                        <label>Ganti Gambar</label>
                        <input type="file" class="form-control" name="gambar">
                        <?php if (!empty($row["gambar"]) && file_exists('img/' . $row["gambar"])) : ?>
                          <img src="img/<?= $row["gambar"] ?>" width="100" class="mt-2">
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                      <button type="button" onclick="resetEditForm(<?= $row['id_brg'] ?>)" class="btn btn-warning">Reset</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <!-- Modal Hapus -->
            <div class="modal fade" id="modalHapus<?= $row["id_brg"] ?>" tabindex="-1">
              <div class="modal-dialog">
                <form method="post">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Hapus Produk</h5>
                    </div>
                    <div class="modal-body">
                      Yakin ingin menghapus produk "<strong><?= $row["nama_brg"] ?></strong>"?
                      <input type="hidden" name="id_brg" value="<?= $row["id_brg"] ?>">
                      <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script>
  function lockRecord(id) {
    $.post("lock.php", {
      table: 'tbl_stok',
      id: id
    }, function(response) {
      if (response.status === 'locked') {
        alert("Record sedang dikunci oleh user lain.");
        location.reload();
      }
    }, "json");
  }

  // Unlock:
  function unlockEdit(id) {
    fetch('unlock.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `table=tbl_stok&id=${id}`
    });
  }

  function unlockBeforeSubmit(id) {
    unlockEdit(id);
    return true; // lanjutkan submit
  }

  function resetEditForm(id) {
    const modal = document.querySelector(`#modalEdit${id}`);
    if (!modal) return;

    modal.querySelectorAll('input:not([type="file"]), textarea').forEach(el => {
      const def = el.getAttribute('data-default');
      if (def !== null) {
        el.value = def;
      }
    });

    unlockEdit(id);
  }

  // Auto-unlock saat modal ditutup
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.modal').forEach(function (modal) {
      modal.addEventListener('hidden.bs.modal', function () {
        const id = modal.id.replace(/\D/g, ''); // Ambil angka dari id modal
        if (modal.id.startsWith('modalEdit')) {
          unlockEdit(id);
        }
      });
    });
  });
</script>


<!-- Pagination -->
<?php
  $sql1 = "SELECT COUNT(*) AS total FROM tbl_stok";
  $total_records = $conn->query($sql1)->fetch_assoc()['total'];
  $jumlah_page = ceil($total_records / $limit);
  $jumlah_number = 1;
  $start_number = max($hlm - $jumlah_number, 1);
  $end_number = min($hlm + $jumlah_number, $jumlah_page);
?>

<p>Total Produk: <?= $total_records; ?></p>
<nav class="mb-2">
  <ul class="pagination justify-content-end">
    <?php if ($hlm == 1): ?>
      <li class="page-item disabled"><span class="page-link">First</span></li>
      <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
    <?php else: ?>
      <li class="page-item halaman" id="1"><a class="page-link" href="#">First</a></li>
      <li class="page-item halaman" id="<?= $hlm - 1 ?>"><a class="page-link" href="#">&laquo;</a></li>
    <?php endif; ?>

    <?php for ($i = $start_number; $i <= $end_number; $i++): ?>
      <li class="page-item halaman<?= ($hlm == $i ? ' active' : '') ?>" id="<?= $i ?>"><a class="page-link" href="#"><?= $i ?></a></li>
    <?php endfor; ?>

    <?php if ($hlm == $jumlah_page): ?>
      <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
      <li class="page-item disabled"><span class="page-link">Last</span></li>
    <?php else: ?>
      <li class="page-item halaman" id="<?= $hlm + 1 ?>"><a class="page-link" href="#">&raquo;</a></li>
      <li class="page-item halaman" id="<?= $jumlah_page ?>"><a class="page-link" href="#">Last</a></li>
    <?php endif; ?>
  </ul>
</nav>

