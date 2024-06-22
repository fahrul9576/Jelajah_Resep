<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'jelajah_resep');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah data user diterima
if (isset($_POST['user_id']) && isset($_POST['username']) && isset($_POST['email'])) {
    $userId = $conn->real_escape_string($_POST['user_id']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);

    // Query untuk mengupdate user
    $sql = "UPDATE users SET username='$username', email='$email' WHERE id=$userId";

    if ($conn->query($sql) === TRUE) {
        echo "User berhasil diupdate";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Data tidak lengkap";
}

$conn->close();
