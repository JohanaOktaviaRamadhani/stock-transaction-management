<?php
session_start();
include "koneksi.php";

$id = $_POST['id'];
$table = 'tbl_transaksi';

$stmt = $conn->prepare("DELETE FROM tbl_trsk_lock WHERE table_name = ? AND record_id = ?");
$stmt->bind_param("si", $table, $id);
$stmt->execute();
$stmt->close();
$conn->close();
