<?php
// Informasi koneksi database XAMPP 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jelajah_resep";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi apakah berhasil atau tidak
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
