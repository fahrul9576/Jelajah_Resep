<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'jelajah_resep');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mendapatkan daftar user
$users = $conn->query("SELECT * FROM users");
?>
<script src="js/script.js"></script>
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Daftar User</h2>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Username</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $users->fetch_assoc()) : ?>
                <tr class="text-center">
                    <td class="py-2 px-4 border-b"><?php echo $user['id']; ?></td>
                    <td class="py-2 px-4 border-b"><?php echo $user['username']; ?></td>
                    <td class="py-2 px-4 border-b"><?php echo $user['email']; ?></td>
                    <td class="py-2 px-4 border-b">
                        <button class="bg-blue-500 text-white py-1 px-3 rounded mr-2" onclick="showEditForm(<?php echo $user['id']; ?>, '<?php echo $user['username']; ?>', '<?php echo $user['email']; ?>')">Edit</button>
                        <button class="bg-red-500 text-white py-1 px-3 rounded" onclick="deleteUser(<?php echo $user['id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Edit Form Modal -->
<div id="editFormModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-2xl font-bold mb-4">Edit User</h2>
        <input type="hidden" id="editUserId">
        <div class="mb-4">
            <label for="editUsername" class="block text-gray-700">Username</label>
            <input type="text" id="editUsername" class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="editEmail" class="block text-gray-700">Email</label>
            <input type="email" id="editEmail" class="w-full p-2 border rounded">
        </div>
        <div class="flex justify-end">
            <button class="bg-gray-500 text-white py-2 px-4 rounded mr-2" onclick="closeEditForm()">Cancel</button>
            <button class="bg-blue-500 text-white py-2 px-4 rounded" onclick="editUser()">Save</button>
        </div>
    </div>
</div>

<script src="js/script.js"></script>
