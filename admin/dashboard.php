<?php
include "db.php";

// Query untuk mendapatkan jumlah user dan resep
$user_count = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$recipe_count = $conn->query("SELECT COUNT(*) AS count FROM resep_user")->fetch_assoc()['count'];
?>

<div class="grid grid-cols-2 gap-4">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-2">Jumlah User</h2>
        <p class="text-4xl"><?php echo $user_count; ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-2">Jumlah Resep</h2>
        <p class="text-4xl"><?php echo $recipe_count; ?></p>
    </div>
</div>