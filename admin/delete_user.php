<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'jelajah_resep');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah user_id diterima
if (isset($_POST['user_id'])) {
    $userId = $conn->real_escape_string($_POST['user_id']);

    // Query untuk menghapus user
    $sql = "DELETE FROM users WHERE id = $userId";

    if ($conn->query($sql) === TRUE) {
        echo "User berhasil dihapus";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No user_id received";
}

$conn->close();
