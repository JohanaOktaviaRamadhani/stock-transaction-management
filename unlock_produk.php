<?php
session_start();
include "koneksi.php";

$id_brg = $_POST['id_brg'] ?? 0;
$username = $_SESSION['nama_admin'] ?? 'unknown';

$stmt = $conn->prepare("UPDATE tbl_stok 
                        SET is_locked = 0, locked_by = NULL, locked_at = NULL 
                        WHERE id_brg = ? AND locked_by = ?");
$stmt->bind_param("is", $id_brg, $username);
$stmt->execute();
$stmt->close();
