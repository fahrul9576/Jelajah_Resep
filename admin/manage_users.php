<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'jelajah_resep');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mendapatkan daftar user
$users = $conn->query("SELECT * FROM users");
?>

<div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Daftar User</h2>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Nama</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $users->fetch_assoc()) : ?>
                <tr class="text-center">
                    <td class="py-2 px-4 border-b"><?php echo $user['id_member']; ?></td>
                    <td class="py-2 px-4 border-b"><?php echo $user['nama_member']; ?></td>
                    <td class="py-2 px-4 border-b"><?php echo $user['email']; ?></td>
                    <td class="py-2 px-4 border-b">
                        <button class="bg-blue-500 text-white py-1 px-3 rounded mr-2">Edit</button>
                        <button class="bg-red-500 text-white py-1 px-3 rounded" onclick="deleteUser(<?php echo $user['id_member']; ?>)">Delete</button>

                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>