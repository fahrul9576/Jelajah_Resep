<?php
// Your PHP code to handle login form submission
session_start(); // Start session for storing login information
include 'base_head.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $servername = "localhost"; // Replace with your MySQL host
    $username = "root"; // Replace with your MySQL username
    $password = ""; // Replace with your MySQL password
    $dbname = "jelajah_resep"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get data from the login form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to fetch user data based on email
    $sql = "SELECT id, username, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Login successful, store user data in session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            // Redirect to dashboard or any other authenticated page
            header("Location: dashboard.php");
            exit();
        } else {
            // If password is incorrect, show error message
            $error_message = "Email atau password salah. Silakan coba lagi.";
        }
    } else {
        // If user not found, show error message
        $error_message = "Email atau password salah. Silakan coba lagi.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .background-image {
            background-image: url('anime.jpeg');
            /* Ganti path ini dengan path gambar background Anda */
            background-size: cover;
            background-position: center;
        }

        .backdrop {
            backdrop-filter: blur(5px);
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body class="background-image min-h-screen flex items-center justify-center">
    <div class="backdrop p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-white text-3xl font-bold mb-6 text-center">Masuk</h2>
        <?php if (isset($error_message)) { ?>
            <p class="text-red-500 text-center"><?php echo $error_message; ?></p>
        <?php } ?>
        <form method="post">
            <div class="mb-4">
                <input type="email" name="email" placeholder="Email" class="w-full px-4 py-2 rounded-lg bg-white text-gray-800 shadow-md focus:outline-none">
            </div>
            <div class="mb-4 relative">
                <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 rounded-lg bg-white text-gray-800 shadow-md focus:outline-none" id="password">
                <button type="button" class="absolute right-4 top-3" id="togglePassword">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            <div class="mb-4 text-right">
                <a href="#" class="text-orange-500 hover:underline">Lupa kata sandi?</a>
            </div>
            <button type="submit" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg shadow-md font-bold">Masuk</button>
        </form>
        <p class="text-white text-center mt-4">Atau belum memiliki akun? <a href="daftar.php" class="text-orange-500 hover:underline">Daftar</a></p>
        <div class="text-center mt-4">
            <a href="index.php" class="text-white hover:underline">Kembali ke home</a>
        </div>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;

            // Update icon
            this.innerHTML = type === 'password' ?
                `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>` :
                `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>`;
        });
    </script>
</body>

</html>