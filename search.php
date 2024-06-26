<?php
include 'base_head.php';
include 'header.php';

// Koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "jelajah_resep");

// Mendapatkan query pencarian dari URL
$query = isset($_GET['q']) ? $_GET['q'] : '';

// Fungsi untuk membuat request ke API dan menyimpan data resep ke dalam database
function fetchRecipesFromAPIAndSaveToDatabase($query, $koneksi)
{
    $base_url = "https://www.dapurumami.com/";
    $resep_API = "search?module=recipe&q=" . urlencode($query) . "&source=search&mode=ajax";
    $url = $base_url . $resep_API;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    $recipes = isset($data['data']) ? array_slice($data['data'], 0, 9) : [];

    // Simpan setiap resep ke dalam database, hanya jika belum ada di database
    foreach ($recipes as $recipe) {
        $id_resep = mysqli_real_escape_string($koneksi, $recipe['id']);
        $check_duplicate_sql = "SELECT * FROM resep_user WHERE id_resep = '$id_resep'";
        $check_result = mysqli_query($koneksi, $check_duplicate_sql);
        if (mysqli_num_rows($check_result) == 0) {
            // Hilangkan spasi dari username
            $username = mysqli_real_escape_string($koneksi, $recipe['user_name']);
            $username = str_replace(' ', '', $username);

            // Cek apakah username sudah ada
            $check_user_sql = "SELECT * FROM users WHERE username = '$username'";
            $check_user_result = mysqli_query($koneksi, $check_user_sql);
            if (mysqli_num_rows($check_user_result) == 0) {
                // Tambahkan pengguna jika belum ada
                addUser($username, $koneksi);
            }

            // Ambil user_id dari tabel users
            $user_id_query = "SELECT id FROM users WHERE username = '$username'";
            $user_id_result = mysqli_query($koneksi, $user_id_query);
            $user_id_row = mysqli_fetch_assoc($user_id_result);
            $user_id = $user_id_row['id'];

            $nama_resep = mysqli_real_escape_string($koneksi, $recipe['recipe_name']);
            $bahan = mysqli_real_escape_string($koneksi, $recipe['ingredients_new']); // Bahan dari API
            $langkah = mysqli_real_escape_string($koneksi, $recipe['steps_new']); // Langkah-langkah dari API
            $gambar = mysqli_real_escape_string($koneksi, $base_url . $recipe['recipe_image']);
            $deskripsi = mysqli_real_escape_string($koneksi, $recipe['recipe_descr']);

            // Simpan resep ke dalam database
            $insert_sql = "INSERT INTO resep_user (id_resep, user_id, nama_resep, bahan, langkah, gambar, deskripsi) VALUES ('$id_resep', '$user_id', '$nama_resep', '$bahan', '$langkah', '$gambar', '$deskripsi')";
            mysqli_query($koneksi, $insert_sql);
        }
    }

    return $recipes;
}

// Fungsi untuk menambahkan pengguna dengan data yang diberikan
function addUser($username, $koneksi)
{
    $email = $username . "@gmail.com"; // Format email sederhana, sesuaikan dengan kebutuhan Anda
    $password = "tess123"; // Kata sandi default, sesuaikan dengan kebutuhan Anda

    // Kirim permintaan POST ke endpoint daftar.php
    $daftar_url = "http://localhost/Jelajah%20Resep/daftar.php";
    $data = [
        'username' => $username,
        'email' => $email,
        'password' => $password
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $daftar_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Mengembalikan respons dari endpoint daftar.php
    return $response;
}

// Fungsi untuk mendapatkan resep dari database
function fetchRecipesFromDatabase($query, $koneksi)
{
    $sql = "SELECT * FROM resep_user WHERE nama_resep LIKE'%" . mysqli_real_escape_string($koneksi, $query) . "%'";
    $result = mysqli_query($koneksi, $sql);

    $recipes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $recipes[] = [
            'id' => $row['id_resep'],
            'recipe_name' => $row['nama_resep'],
            'recipe_image' => $row['gambar']
        ];
    }
    return $recipes;
}

// Ambil data resep dari database
$databaseRecipes = fetchRecipesFromDatabase($query, $koneksi);

// Ambil data resep dari API dan simpan ke dalam database
$apiRecipes = fetchRecipesFromAPIAndSaveToDatabase($query, $koneksi);

// Gabungkan hasil dari database dan API
$recipes = array_merge($databaseRecipes, $apiRecipes);
?>

<body class="bg-gray-100">
    <div class="container mx-auto px-5 py-10">
        <?php if (!empty($databaseRecipes)) : ?>
            <h2 class="text-3xl font-bold mb-4 text-center">Hasil untuk "<?php echo htmlspecialchars($query); ?>"</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($databaseRecipes as $recipe) : ?>
                    <?php
                    $image_url = "proxy.php?url=" . urlencode($recipe['recipe_image']);
                    ?>
                    <div class="flex flex-col items-center bg-white rounded-lg shadow-md p-4">
                        <div class="image-container">
                            <a href="detail_resep.php?id=<?php echo $recipe['id']; ?>">
                                <img src="<?php echo $image_url; ?>" class="recipe-image rounded-lg" style="width: 328px; height: 229px;">
                            </a>
                        </div>
                        <a href="detail_resep.php?id=<?php echo $recipe['id']; ?>" class="text-center mt-2 text-gray-800 font-bold"><?php echo htmlspecialchars($recipe['recipe_name']); ?></a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="text-gray-700 text-center">No results found.</p>
        <?php endif; ?>
    </div>
</body>

<?php include 'footer.php'; ?>