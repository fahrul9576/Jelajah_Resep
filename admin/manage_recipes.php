<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'jelajah_resep');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mendapatkan daftar resep
$recipes = $conn->query("SELECT * FROM resep_user");
?>

<div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Daftar Resep</h2>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Nama Resep</th>
                <th class="py-2 px-4 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($recipe = $recipes->fetch_assoc()) : ?>
                <tr class="text-center">
                    <td class="py-2 px-4 border-b"><?php echo $recipe['id_resep']; ?></td>
                    <td class="py-2 px-4 border-b"><?php echo $recipe['nama_resep']; ?></td>
                    <td class="py-2 px-4 border-b">
                        <button class="bg-red-500 text-white py-1 px-3 rounded" onclick="deleteRecipe(<?php echo $recipe['id_resep']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="js/script.js"></script>
