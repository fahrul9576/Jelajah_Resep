<?php
// Mulai sesi
session_start();
include 'db.php';

// Jika pengguna sudah login, user di alihkan ke halaman dashboard
if (isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}



// Pesan kesalahan
$errorMessage = '';

// Jika formulir login dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari formulir
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk memeriksa apakah pengguna ada di database
    $query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = $conn->query($query);

    // Periksa apakah ada pengguna dengan detail yang diberikan
    if ($result->num_rows == 1) {
        // Pengguna ada, atur sesi dan arahkan ke halaman dashboard
        $_SESSION['email'] = $email;
        header("Location: index.php");
        exit;
    } else {
        // Jika tidak, tampilkan pesan kesalahan
        $errorMessage = "email atau password salah. Silakan coba lagi.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex justify-center items-center h-screen bg-gray-100">
    <div class="w-full max-w-xs">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="email" name="email">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************" name="password">
                <p class="text-red-500 text-xs italic"><?php echo $errorMessage; ?></p>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Sign In
                </button>
            </div>
        </form>
        <p class="text-center text-gray-500 text-xs">
            &copy;2024 Jelajah Resep. All rights reserved.
        </p>
    </div>
</body>

</html>