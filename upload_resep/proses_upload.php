<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

require '../koneksi.php'; // Adjust the path to your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $bahan = $_POST['bahan'];
    $langkah = $_POST['langkah'];
    $gambar = $_FILES['gambar']['name'];
    $user_id = $_SESSION['user_id'];

    // Upload the image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($gambar);
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO resep_user (nama_resep, bahan, langkah, gambar, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $judul, $bahan, $langkah, $gambar, $user_id);

        if ($stmt->execute()) {
            header("Location: upload_resep.php?status=success");
        } else {
            header("Location: upload_resep.php?status=error&message=" . $stmt->error);
        }
        $stmt->close();
    } else {
        header("Location: upload_resep.php?status=error&message=Gagal mengupload gambar");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Resep</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 md:p-16 max-w-lg mx-auto mt-10">
        <h1 class="text-3xl font-bold text-center text-gray-700 mb-8">Upload Resep Baru</h1>
        <form action="proses_upload.php" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label for="judul" class="block text-lg font-semibold text-gray-600">Judul Resep</label>
                <input type="text" id="judul" name="judul" class="border rounded-lg px-4 py-2 w-full mt-2 focus:ring focus:ring-blue-200 focus:outline-none">
            </div>
            <div>
                <label for="bahan" class="block text-lg font-semibold text-gray-600">Bahan-Bahan</label>
                <textarea id="bahan" name="bahan" class="border rounded-lg px-4 py-2 w-full h-32 mt-2 focus:ring focus:ring-blue-200 focus:outline-none"></textarea>
            </div>
            <div>
                <label for="langkah" class="block text-lg font-semibold text-gray-600">Langkah-Langkah</label>
                <textarea id="langkah" name="langkah" class="border rounded-lg px-4 py-2 w-full h-32 mt-2 focus:ring focus:ring-blue-200 focus:outline-none"></textarea>
            </div>
            <div>
                <label for="gambar" class="block text-lg font-semibold text-gray-600">Gambar Resep</label>
                <input type="file" id="gambar" name="gambar" class="border rounded-lg px-4 py-2 w-full mt-2 focus:ring focus:ring-blue-200 focus:outline-none">
            </div>
            <div class="text-center">
                <button type="submit" class="bg-gradient-to-r from-green-400 to-blue-500 text-white px-6 py-3 rounded-lg hover:shadow-lg transition duration-300 ease-in-out transform hover:scale-105">Simpan Resep</button>
            </div>
        </form>
    </div>

    <?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'success') {
            echo "<script>
            swal({
                title: 'Sukses!',
                text: 'Resep berhasil disimpan. Ingin membagikan ke sosial media?',
                icon: 'success',
                buttons: {
                    cancel: 'Tidak',
                    confirm: 'Bagikan'
                }
            }).then((willShare) => {
                if (willShare) {
                    window.location.href = 'share_to_social.php';
                }
            });
            </script>";
        } elseif ($_GET['status'] == 'error') {
            echo "<script>swal('Error!', 'Gagal menyimpan resep: " . htmlspecialchars($_GET['message']) . "', 'error');</script>";
        }
    }
    ?>
    <?php include "../footer.php"; ?>
</body>

</html>