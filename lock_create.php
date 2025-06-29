<?php
session_start();
include "koneksi.php";

$username = $_SESSION['nama_admin'];
$table = $_POST['table'];
$record_id = 0; // pakai 0 untuk form tambah
$now = date("Y-m-d H:i:s");

// Cek apakah sudah di-lock user lain
$cek = $conn->prepare("SELECT * FROM tbl_lock WHERE table_name=? AND record_id=?");
$cek->bind_param("si", $table, $record_id);
$cek->execute();
$res = $cek->get_result();

if ($res->num_rows > 0) {
    $data = $res->fetch_assoc();
    if ($data['locked_by'] != $username && strtotime($data['locked_at']) > time() - 300) {
        echo json_encode(['status' => 'locked']);
        exit;
    } else {
        // Override lock (expired)
        $stmt = $conn->prepare("UPDATE tbl_lock SET locked_by=?, locked_at=? WHERE table_name=? AND record_id=?");
        $stmt->bind_param("sssi", $username, $now, $table, $record_id);
        $stmt->execute();
    }
} else {
    $stmt = $conn->prepare("INSERT INTO tbl_lock (table_name, record_id, locked_by, locked_at) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $table, $record_id, $username, $now);
    $stmt->execute();
}

echo json_encode(['status' => 'ok']);
