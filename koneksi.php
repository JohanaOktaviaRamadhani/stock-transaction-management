<?php
date_default_timezone_set('Asia/Jakarta');

$servername = "localhost";
$username = "root";
$password = "";
$db = "db_webdailyjurnal";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Unlock otomatis jika sudah lebih dari 5 menit
$conn->query("UPDATE tbl_trsk_lock SET is_locked = 0 WHERE TIMESTAMPDIFF(MINUTE, locked_at, NOW()) > 5");
$conn->query("UPDATE tbl_lock SET is_locked = 0 WHERE TIMESTAMPDIFF(MINUTE, locked_at, NOW()) > 5");
?>
