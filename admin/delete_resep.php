<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'jelajah_resep');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah id_resep diterima
if (isset($_POST['id_resep'])) {
    $idResep = $conn->real_escape_string($_POST['id_resep']);

    // Query untuk menghapus resep
    $sql = "DELETE FROM resep_user WHERE id_resep = $idResep";

    if ($conn->query($sql) === TRUE) {
        echo "Resep berhasil dihapus";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No id_resep received";
}

$conn->close();
