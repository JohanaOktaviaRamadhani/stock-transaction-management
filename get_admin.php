<?php
include "koneksi.php";

$id = $_GET['id'];

$query = $conn->query("SELECT nama FROM tbl_admin WHERE id_admin = '$id'");
$data = $query->fetch_assoc();

echo json_encode([
    'nama_admin' => $data['nama'] ?? ''
]);
?>
