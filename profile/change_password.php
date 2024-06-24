<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

require '../database.php'; // Adjust the path to your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['user_id'];

    if ($new_password !== $confirm_password) {
        $error = "Password baru dan konfirmasi password tidak cocok.";
    } else {
        // Fetch the current password from the database
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if (password_verify($current_password, $user['password'])) {
            // Update the password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hashed_password, $user_id);

            if ($stmt->execute()) {
                $success = "Password berhasil diubah.";
            } else {
                $error = "Gagal mengubah password.";
            }
            $stmt->close();
        } else {
            $error = "Password saat ini salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold text-center text-gray-700 mb-8">Ganti Password</h1>
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg mx-auto">
            <?php if (isset($error)) : ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $error; ?></span>
                </div>
            <?php endif; ?>
            <?php if (isset($success)) : ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $success; ?></span>
                </div>
            <?php endif; ?>
            <form action="change_password.php" method="POST" class="space-y-6">
                <div>
                    <label for="current_password" class="block text-lg font-semibold text-gray-600">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" class="border rounded-lg px-4 py-2 w-full mt-2 focus:ring focus:ring-blue-200 focus:outline-none">
                </div>
                <div>
                    <label for="new_password" class="block text-lg font-semibold text-gray-600">Password Baru</label>
                    <input type="password" id="new_password" name="new_password" class="border rounded-lg px-4 py-2 w-full mt-2 focus:ring focus:ring-blue-200 focus:outline-none">
                </div>
                <div>
                    <label for="confirm_password" class="block text-lg font-semibold text-gray-600">Konfirmasi Password Baru</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="border rounded-lg px-4 py-2 w-full mt-2 focus:ring focus:ring-blue-200 focus:outline-none">
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-gradient-to-r from-green-400 to-blue-500 text-white px-6 py-3 rounded-lg hover:shadow-lg transition duration-300 ease-in-out transform hover:scale-105">Ganti Password</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>