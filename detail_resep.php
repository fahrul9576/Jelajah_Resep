<?php
include 'base_head.php';
include 'header.php';

// Mulai sesi


// Koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "jelajah_resep");

// Mendapatkan ID resep dari URL
$id_resep = isset($_GET['id']) ? $_GET['id'] : '';

// Fungsi untuk mengambil data resep dari database berdasarkan ID
function fetchRecipeFromDatabase($id_resep, $koneksi)
{
    $sql = "SELECT * FROM resep_user WHERE id_resep = '$id_resep'";
    $result = mysqli_query($koneksi, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    } else {
        return false;
    }
}

// Fungsi untuk mendownload gambar dari URL
function fetchImageFromURL($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $image_data = curl_exec($ch);
    curl_close($ch);
    return $image_data;
}

// Fungsi untuk mengubah format bahan dari JSON menjadi teks
function formatIngredients($ingredients)
{
    $ingredients = json_decode($ingredients, true);
    $formattedIngredients = "";
    foreach ($ingredients as $section) {
        foreach ($section['contents'] as $ingredient) {
            $formattedIngredients .= "- " . $ingredient['v_page_element_ingredient_item'] . "\n";
        }
    }
    return $formattedIngredients;
}

// Fungsi untuk mengubah format langkah-langkah dari JSON menjadi teks
function formatSteps($steps)
{
    $steps = json_decode($steps, true);
    $formattedSteps = "";
    foreach ($steps as $step) {
        $formattedSteps .= $step['step'] . "\n";
    }
    return $formattedSteps;
}

// Fungsi untuk menyimpan komentar ke database
function saveComment($id_resep, $user_id, $komentar, $koneksi)
{
    $stmt = $koneksi->prepare("INSERT INTO feedback (id_resep, user_id, komentar) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $id_resep, $user_id, $komentar);
    return $stmt->execute();
}

// Ambil data resep dari database berdasarkan ID
$recipe = fetchRecipeFromDatabase($id_resep, $koneksi);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['komentar'])) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $komentar = $_POST['komentar'];
        if (saveComment($id_resep, $user_id, $komentar, $koneksi)) {
            $success_message = "Komentar berhasil disimpan!";
        } else {
            $error_message = "Gagal menyimpan komentar. Silakan coba lagi.";
        }
    } else {
        $error_message = "Anda harus login untuk memberikan komentar.";
    }
}
function fetchCommentsFromDatabase($id_resep, $koneksi)
{
    $sql = "
        SELECT f.komentar, u.username, f.created_at 
        FROM feedback f 
        JOIN users u ON f.user_id = u.id 
        WHERE f.id_resep = ?
        ORDER BY f.created_at DESC";

    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_resep);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
    return $comments;
}


// Ambil data komentar dari database berdasarkan ID resep
$comments = fetchCommentsFromDatabase($id_resep, $koneksi);

?>

<body class="bg-gray-100">
    <div class="container mx-auto px-5 py-10">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
            <?php if ($recipe) : ?>
                <h2 class="text-3xl font-bold mb-4 text-center"><?php echo htmlspecialchars($recipe['nama_resep']); ?></h2>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600">Dibuat: <?php echo htmlspecialchars($recipe['created_at']); ?></span>
                </div>
                <div class="relative overflow-hidden rounded-lg" style="aspect-ratio: 16/9;">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode(fetchImageFromURL($recipe['gambar'])); ?>" alt="<?php echo htmlspecialchars($recipe['nama_resep']); ?>" class="absolute inset-0 w-full h-full object-cover rounded-lg">
                </div>
                <h2 class="mb-4 text-center"><?php echo htmlspecialchars($recipe['deskripsi']); ?></h2>
                <div class="mt-8">
                    <h3 class="text-2xl font-semibold mb-2">Bahan-bahan:</h3>
                    <p class="text-gray-700 leading-relaxed"><?php echo nl2br(formatIngredients($recipe['bahan'])); ?></p>
                </div>
                <div class="mt-8">
                    <h3 class="text-2xl font-semibold mb-2">Langkah-langkah:</h3>
                    <p class="text-gray-700 leading-relaxed"><?php echo nl2br(formatSteps($recipe['langkah'])); ?></p>
                </div>

                <!-- Tampilkan Komentar -->
                <div class="mt-8">
                    <h3 class="text-2xl font-semibold mb-2">Komentar:</h3>
                    <?php if ($comments) : ?>
                        <?php foreach ($comments as $comment) : ?>
                            <div class="mb-4 p-4 border border-gray-300 rounded-md">
                                <p class="text-gray-700"><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong> <?php echo htmlspecialchars($comment['komentar']); ?></p>
                                <p class="text-gray-500 text-sm"><?php echo htmlspecialchars($comment['created_at']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-gray-700">Belum ada komentar.</p>
                    <?php endif; ?>
                </div>

                <!-- Form Komentar -->
                <div class="mt-8">
                    <h3 class="text-2xl font-semibold mb-2">Tinggalkan Komentar:</h3>
                    <?php if (isset($success_message)) : ?>
                        <p class="text-green-500"><?php echo $success_message; ?></p>
                    <?php endif; ?>
                    <?php if (isset($error_message)) : ?>
                        <p class="text-red-500"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <form action="" method="POST">
                            <textarea name="komentar" rows="4" class="w-full p-2 border border-gray-300 rounded-md" required></textarea>
                            <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-md">Kirim</button>
                        </form>
                    <?php else : ?>
                        <p class="text-red-500">Anda harus <a href="login.php" class="text-blue-500">login</a> untuk memberikan komentar.</p>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <p class="text-gray-700 text-center">Resep tidak ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

<?php include 'footer.php'; ?>