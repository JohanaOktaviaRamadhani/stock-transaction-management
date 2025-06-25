<?php
include "koneksi.php";

$id = $_GET['id'];

$query = $conn->query("SELECT nama_brg, harga FROM tbl_stok WHERE id_brg = '$id'");
$data = $query->fetch_assoc();

echo json_encode([
    'nama_brg' => $data['nama_brg'] ?? '',
    'harga' => $data['harga'] ?? 0
]);
?>
