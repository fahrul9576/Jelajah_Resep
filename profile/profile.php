<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include "../header.php";
require '../koneksi.php'; // Sesuaikan path dengan file koneksi database Anda

$user_id = $_SESSION['user_id'];

// Ambil informasi profil pengguna dari database
$stmt = $conn->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
// Fetch the number of recipes created by the user
$stmt1 = $conn->prepare("SELECT COUNT(*) AS recipe_count FROM resep_user WHERE user_id = ?");
$stmt1->bind_param("i", $user_id);
$stmt1->execute();
$result1 = $stmt1->get_result();
$row1 = $result1->fetch_assoc();
$recipe_count = $row1['recipe_count'];
$stmt1->close();

// Variabel untuk menyimpan informasi profil pengguna
$nama = $row['username'];
$email = $row['email'];
$created_at = $row['created_at'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold text-center text-gray-700 mb-8">Profil Pengguna</h1>
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg mx-auto">
            <!-- Informasi profil pengguna -->
            <p class="text-lg font-semibold text-gray-600 mb-4">Nama: <?php echo $nama; ?></p>
            <p class="text-lg font-semibold text-gray-600 mb-4">Email: <?php echo $email; ?></p>
            <p class="text-lg font-semibold text-gray-600 mb-4">Tanggal Pembuatan Akun: <?php echo $created_at; ?></p>
            <p class="text-lg font-semibold text-gray-600 mb-4">Jumlah Resep: <?php echo $recipe_count; ?></p>
            <!-- Tombol untuk menampilkan resep yang sudah dibuat -->
            <a href="daftar_resep.php" class="block text-center bg-green-500 text-white px-4 py-2 rounded-lg mb-4">Lihat Resep Saya</a>
            <!-- Link untuk mengubah password -->
            <a href="change_password.php" class="block text-center bg-blue-500 text-white px-4 py-2 rounded-lg mb-4">Ganti Password</a>
            <!-- Link untuk logout -->
            <a href="logout.php" class="block text-center bg-red-500 text-white px-4 py-2 rounded-lg">Logout</a>
        </div>
    </div>
</body>

</html>