<?php
session_start();
include "koneksi.php";

$id_brg = $_POST['id_brg'] ?? 0;
$username = $_SESSION['nama_admin'] ?? 'unknown';

// Auto-release jika sudah expired lebih dari 10 menit
$conn->query("UPDATE tbl_stok 
              SET is_locked = 0, locked_by = NULL, locked_at = NULL 
              WHERE is_locked = 1 AND TIMESTAMPDIFF(MINUTE, locked_at, NOW()) > 10");

// Cek apakah sudah dikunci oleh orang lain
$stmt = $conn->prepare("SELECT is_locked, locked_by FROM tbl_stok WHERE id_brg = ?");
$stmt->bind_param("i", $id_brg);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($row['is_locked'] && $row['locked_by'] !== $username) {
    echo json_encode(["status" => "locked"]);
    exit;
}

// Jika tidak dikunci atau oleh diri sendiri, set lock
$stmt = $conn->prepare("UPDATE tbl_stok SET is_locked = 1, locked_by = ?, locked_at = NOW() WHERE id_brg = ?");
$stmt->bind_param("si", $username, $id_brg);
$stmt->execute();
$stmt->close();

echo json_encode(["status" => "ok"]);
