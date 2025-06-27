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

  .table {
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(162, 139, 212, 0.1);
    animation: fadeInTable 0.6s ease;
    background-color: white;
    border-spacing: 0;
    border-collapse: collapse !important;
  }

  .thead-lilac {
    background-color: var(--lilac-primary) !important;
  }

  .thead-lilac th {
    background-color: var(--lilac-primary) !important;
    color: black !important;
    font-weight: 700;
    font-size: 1.05rem; 
    text-transform: capitalize;
    letter-spacing: 0.5px;
  }

  .table th,
  .table td {
    padding: 0.85rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #ddd;
    font-size: 0.95rem;
    color: var(--text-dark);
    white-space: nowrap;
  }
  .table,
  .table th,
  .table td {
    border: 1px solid #ddd !important;
  }

  .table td:nth-child(2) {
    max-width: 180px;
    white-space: normal;
    word-wrap: break-word;
  }

  .table td:nth-child(3) {
    max-width: 350px;
    white-space: normal;
    word-wrap: break-word;
    text-align: left;
  }

  .table td img {
    border-radius: 0.5rem;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }

  .table-hover tbody tr:hover {
    background-color: var(--table-hover);
  }

  .table tbody tr:nth-child(even) {
    background-color: var(--table-stripe);
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


  .badge {
    padding: 0.5rem 0.75rem;
    font-size: 0.85rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    font-family: 'Quicksand', sans-serif;
    cursor: pointer;
    text-decoration: none;
  }

  .badge:hover {
    transform: scale(1.05);
    opacity: 0.9;
  }

  .badge.text-bg-success {
    background-color: #88d6ba;
    color: #fff;
  }

  .badge.text-bg-danger {
    background-color: #e79999;
    color: #fff;
  }

  .modal-body {
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
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
  }

  input.form-control:focus,
  textarea.form-control:focus {
    border-color: #a28bd4;
    box-shadow: 0 0 0 0.2rem rgba(162, 139, 212, 0.25);
  }

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

  .btn-danger {
    background-color: #e79999;
    border: none;
  }

  .btn-secondary {
    background-color: #d3d3e3;
    color: #4b3f72;
    border: none;
  }

  .pagination .page-link {
    color: var(--text-dark);
    font-family: 'Quicksand', sans-serif;
  }

  .pagination .page-item.active .page-link {
    background-color: var(--lilac-primary);
    color: white;
    border: none;
    box-shadow: 0 2px 6px rgba(162, 139, 212, 0.4);
  }

  .pagination .page-link:hover {
    background-color: var(--table-hover);
  }
</style>

<div class="table-responsive">
  <table class="table table-hover">

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
          <a href="#" class="badge text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id_brg"] ?>">Edit</a>
          <a href="#" class="badge text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id_brg"] ?>">Hapus</a>

          <!-- Modal Edit -->
          <div class="modal fade" id="modalEdit<?= $row["id_brg"] ?>" tabindex="-1">
            <div class="modal-dialog">
              <form method="post" enctype="multipart/form-data">
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

<!-- SCRIPT -->
<script>
  function resetEditForm(id) {
    const modal = document.querySelector(`#modalEdit${id}`);
    if (!modal) return;

    // Reset setiap input dan textarea ke data-default
    modal.querySelectorAll('input:not([type="file"]), textarea').forEach(el => {
      const def = el.getAttribute('data-default');
      if (def !== null) {
        el.value = def;
      }
    });
  }
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

