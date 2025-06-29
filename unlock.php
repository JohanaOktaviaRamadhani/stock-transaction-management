<?php
session_start();
include "koneksi.php";

$table = $_POST['table'];
$id = intval($_POST['id']);
$username = $_SESSION['nama_admin'];

// Hapus lock hanya jika yang nge-lock adalah user ini
$sql = "DELETE FROM tbl_lock WHERE table_name=? AND record_id=? AND locked_by=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sis", $table, $id, $username);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["status" => "unlocked"]);
} else {
    echo json_encode(["status" => "not_owner"]);
}
?>
