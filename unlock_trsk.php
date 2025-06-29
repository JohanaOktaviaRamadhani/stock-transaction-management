<?php
session_start();
include "koneksi.php";

$table = 'tbl_transaksi';
$id = intval($_POST['id'] ?? 0);
$username = $_SESSION['nama_admin'] ?? '';

if (!$id || $username === '') {
    echo json_encode(['success' => false]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM tbl_trsk_lock WHERE table_name = ? AND record_id = ? AND locked_by = ?");
$stmt->bind_param("sis", $table, $id, $username);
$stmt->execute();
$stmt->close();

echo json_encode(['success' => true]);
