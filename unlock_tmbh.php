<?php
session_start();
include "koneksi.php";

$table = $_POST['table'];
$record_id = $_POST['record_id'];

$stmt = $conn->prepare("DELETE FROM tbl_lock WHERE table_name=? AND record_id=?");
$stmt->bind_param("si", $table, $record_id);
$stmt->execute();
$stmt->close();
$conn->close();
?>
