<table class="table table-hover">
    <thead class="table-dark">
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
        <?php
            include "koneksi.php";

            $hlm = (isset($_POST['hlm'])) ? $_POST['hlm'] : 1;
            $limit = 5;
            $limit_start = ($hlm - 1) * $limit;
            $no = $limit_start + 1;

            $sql = "SELECT * FROM tbl_stok ORDER BY tanggal DESC LIMIT $limit_start, $limit";
            $hasil = $conn->query($sql);

            while ($row = $hasil->fetch_assoc()) {
        ?>
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
                    <?php endif; ?>
                </td>
                <td>Rp<?= number_format(isset($row["harga"]) ? $row["harga"] : 0, 0, ',', '.') ?></td>
                <td><?= $row["stok"] ?></td>
                <td>
                    <!-- Aksi Edit & Hapus -->
                    <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id_brg"] ?>"><i class="bi bi-pencil"></i></a>
                    <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id_brg"] ?>"><i class="bi bi-x-circle"></i></a>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="modalEdit<?= $row["id_brg"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id_brg" value="<?= $row["id_brg"] ?>">
                                        <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">

                                        <div class="mb-3">
                                            <label class="form-label">Nama Produk</label>
                                            <input type="text" class="form-control" name="nama_brg" value="<?= $row["nama_brg"] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Deskripsi</label>
                                            <textarea class="form-control" name="deskripsi" required><?= $row["deskripsi"] ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Harga</label>
                                            <input type="number" class="form-control" name="harga" value="<?= $row["harga"] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Stok</label>
                                            <input type="number" class="form-control" name="stok" value="<?= $row["stok"] ?>" required>
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
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Hapus -->
                    <div class="modal fade" id="modalHapus<?= $row["id_brg"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" action="">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Yakin ingin menghapus produk "<strong><?= $row["nama_brg"] ?></strong>"?</p>
                                        <input type="hidden" name="id_brg" value="<?= $row["id_brg"] ?>">
                                        <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <input type="submit" value="hapus" name="hapus" class="btn btn-danger">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Pagination -->
<?php 
    $sql1 = "SELECT * FROM tbl_stok";
    $hasil1 = $conn->query($sql1); 
    $total_records = $hasil1->num_rows;
?>

<p>Total Produk : <?= $total_records; ?></p>
<nav class="mb-2">
    <ul class="pagination justify-content-end">
        <?php
            $jumlah_page = ceil($total_records / $limit);
            $jumlah_number = 1;
            $start_number = ($hlm > $jumlah_number)? $hlm - $jumlah_number : 1;
            $end_number = ($hlm < ($jumlah_page - $jumlah_number))? $hlm + $jumlah_number : $jumlah_page;

            if($hlm == 1){
                echo '<li class="page-item disabled"><a class="page-link" href="#">First</a></li>';
                echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
            } else {
                $link_prev = $hlm - 1;
                echo '<li class="page-item halaman" id="1"><a class="page-link" href="#">First</a></li>';
                echo '<li class="page-item halaman" id="'.$link_prev.'"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
            }

            for($i = $start_number; $i <= $end_number; $i++){
                $link_active = ($hlm == $i)? ' active' : '';
                echo '<li class="page-item halaman'.$link_active.'" id="'.$i.'"><a class="page-link" href="#">'.$i.'</a></li>';
            }

            if($hlm == $jumlah_page){
                echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item disabled"><a class="page-link" href="#">Last</a></li>';
            } else {
                $link_next = $hlm + 1;
                echo '<li class="page-item halaman" id="'.$link_next.'"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item halaman" id="'.$jumlah_page.'"><a class="page-link" href="#">Last</a></li>';
            }
        ?>
    </ul>
</nav>