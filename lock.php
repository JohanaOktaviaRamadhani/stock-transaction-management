<?php
session_start();
include "koneksi.php";

$table = $_POST['table'];
$id = intval($_POST['id']);
$username = $_SESSION['nama_admin'];

// Cek apakah record sudah dikunci
$sql = "SELECT * FROM tbl_lock WHERE table_name=? AND record_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $table, $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['is_locked'] && $row['locked_by'] !== $username) {
        echo json_encode(["status" => "locked"]);
        exit;
    } else {
        // Refresh lock
        $update = $conn->prepare("UPDATE tbl_lock SET is_locked=1, locked_by=?, locked_at=NOW() WHERE table_name=? AND record_id=?");
        $update->bind_param("ssi", $username, $table, $id);
        $update->execute();
    }
} else {
    // Lock baru
    $insert = $conn->prepare("INSERT INTO tbl_lock (table_name, record_id, is_locked, locked_by, locked_at) VALUES (?, ?, 1, ?, NOW())");
    $insert->bind_param("sis", $table, $id, $username);
    $insert->execute();
}

echo json_encode(["status" => "ok"]);
?>
