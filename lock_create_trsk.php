<?php
session_start();
include "koneksi.php";

$table = 'tbl_transaksi';
$record_id = 0;
$locked_by = $_SESSION['nama_admin'];
$locked_at = date('Y-m-d H:i:s');

// Cek apakah sudah ada lock
$cek = $conn->prepare("SELECT * FROM tbl_trsk_lock WHERE table_name=? AND record_id=?");
$cek->bind_param("si", $table, $record_id);
$cek->execute();
$res = $cek->get_result();

if ($res->num_rows > 0) {
    echo json_encode(["status" => "locked"]);
} else {
    // Insert lock
    $stmt = $conn->prepare("INSERT INTO tbl_trsk_lock (table_name, record_id, locked_by, locked_at) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $table, $record_id, $locked_by, $locked_at);
    $stmt->execute();
    echo json_encode(["status" => "success"]);
}
