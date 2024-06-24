<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include "../header.php";
require '../koneksi.php'; // Sesuaikan path dengan file koneksi database Anda

$user_id = $_SESSION['user_id'];

// Pastikan id_user diset dan merupakan integer
if (isset($_GET['id_user']) && filter_var($_GET['id_user'], FILTER_VALIDATE_INT)) {
    $id_user = $_GET['id_user'];
} else {
    // Jika id_user tidak diset atau tidak valid, gunakan id_user dari sesi
    $id_user = $user_id;
}

// Ambil informasi resep yang dimiliki oleh pengguna dengan id_user tertentu
$stmt = $conn->prepare("SELECT * FROM resep_user WHERE user_id = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Resep</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold text-center text-gray-700 mb-8">Daftar Resep</h1>
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg mx-auto">
            <ul>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <li class="text-lg font-semibold text-gray-600 mb-4"><?php echo $row['nama_resep']; ?></li>
                <?php endwhile; ?>
            </ul>
            <a href="profile.php" class="block text-center bg-blue-500 text-white px-4 py-2 rounded-lg mt-4">Kembali ke Profil</a>
        </div>
    </div>
</body>

</html>