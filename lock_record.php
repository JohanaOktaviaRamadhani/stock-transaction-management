<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['nama_admin'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}

$id_brg = $_POST['id_brg'];
$table_name = $_POST['table_name'];
$username = $_SESSION['nama_admin'];

// Cek apakah record sudah di-lock user lain
$cek = $conn->prepare("SELECT * FROM tbl_lock WHERE table_name = ? AND record_id = ?");
$cek->bind_param("si", $table_name, $id_brg);
$cek->execute();
$result = $cek->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['locked_by'] !== $username) {
        echo json_encode(['status' => 'locked', 'locked_by' => $row['locked_by']]);
        exit;
    }
    // Jika sama user, lanjut update timestamp
    $stmt = $conn->prepare("UPDATE tbl_lock SET locked_at = NOW() WHERE table_name = ? AND record_id = ?");
    $stmt->bind_param("si", $table_name, $id_brg);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
} else {
    // Lock record
    $stmt = $conn->prepare("INSERT INTO tbl_lock (table_name, record_id, locked_by, locked_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sis", $table_name, $id_brg, $username);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
}
?>
