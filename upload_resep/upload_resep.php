<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Database connection
include "../koneksi.php";
include "../header.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $bahan = $_POST['bahan'];
    $langkah = $_POST['langkah'];
    $gambar = $_FILES['gambar'];

    // Handle file upload
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($gambar["name"]);
    if (move_uploaded_file($gambar["tmp_name"], $target_file)) {
        $image_path = basename($gambar["name"]);
    } else {
        header("Location: upload_resep.php?status=error&message=Failed to upload image");
        exit();
    }

    // Save the recipe to the database
    $user_id = $_SESSION['user_id'];
    $query = "INSERT INTO resep_user (user_id, nama_resep, bahan, langkah, gambar) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issss", $user_id, $judul, $bahan, $langkah, $image_path);

    if ($stmt->execute()) {
        // Redirect to profile page with sharing options
        header("Location: ../profile/profile.php?status=success&share=true");
        exit();
    } else {
        header("Location: upload_resep.php?status=error&message=Failed to save recipe");
        exit();
    }
}

?>

<body class="bg-gradient-to-r from-blue-400 to-purple-500 min-h-screen flex flex-col">

    <div class="container flex-grow"> <!-- Menggunakan flex-grow untuk mengisi ruang yang tersisa -->
        <div class="bg-gray-100 h-auto w-auto shadow-lg rounded-lg p-8 mt-10">
            <h1 class="text-3xl font-bold text-center text-gray-700 mb-8">Upload Resep Baru</h1>
            <form action="proses_upload.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label for="judul" class="block text-lg font-semibold text-gray-600">Judul Resep</label>
                    <input type="text" id="judul" name="judul" class="border rounded-lg px-4 py-2 w-full mt-2 focus:ring focus:ring-blue-200 focus:outline-none">
                </div>
                <div>
                    <label for="bahan" class="block text-lg font-semibold text-gray-600">Bahan-Bahan</label>
                    <textarea id="bahan" name="bahan" class="border rounded-lg px-4 py-2 w-full h-48 mt-2 focus:ring focus:ring-blue-200 focus:outline-none"></textarea>
                </div>
                <div>
                    <label for="langkah" class="block text-lg font-semibold text-gray-600">Langkah-Langkah</label>
                    <textarea id="langkah" name="langkah" class="border rounded-lg px-4 py-2 w-full h-48 mt-2 focus:ring focus:ring-blue-200 focus:outline-none"></textarea>
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
                echo "<script>swal('Sukses!', 'Resep berhasil disimpan', 'success');</script>";
            } elseif ($_GET['status'] == 'error') {
                echo "<script>swal('Error!', 'Gagal menyimpan resep: " . htmlspecialchars($_GET['message']) . "', 'error');</script>";
            }
        }
        ?>
    </div>
</body>

<?php include "../footer.php"; ?>