<?php
session_start();
include "koneksi.php";

$table = 'tbl_transaksi'; 
$id = intval($_POST['id'] ?? 0);
$username = $_SESSION['nama_admin'] ?? '';

if (!$id || $username === '') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

// Cek apakah data sudah dikunci
$stmt = $conn->prepare("SELECT is_locked, locked_by, locked_at FROM tbl_trsk_lock WHERE table_name = ? AND record_id = ?");
$stmt->bind_param("si", $table, $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if ($row) {
    if ($row['is_locked'] == 1 && $row['locked_by'] !== $username) {
        echo json_encode(['success' => false, 'message' => 'Data sedang dikunci oleh ' . $row['locked_by']]);
        exit;
    } else {
        // Kunci ulang dengan update
        $update = $conn->prepare("UPDATE tbl_trsk_lock SET is_locked = 1, locked_by = ?, locked_at = NOW() WHERE table_name = ? AND record_id = ?");
        $update->bind_param("ssi", $username, $table, $id);
        $update->execute();
        $update->close();
    }
} else {
    // Insert baru
    $insert = $conn->prepare("INSERT INTO tbl_trsk_lock (table_name, record_id, is_locked, locked_by, locked_at) VALUES (?, ?, 1, ?, NOW())");
    $insert->bind_param("sis", $table, $id, $username);
    $insert->execute();
    $insert->close();
}

echo json_encode(['success' => true]);
?>
