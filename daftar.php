<?php // Start session for storing login information
include 'base_head.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $servername = "localhost"; // Replace with your MySQL host
    $db_username = "root"; // Replace with your MySQL username
    $db_password = ""; // Replace with your MySQL password
    $dbname = "jelajah_resep"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get data from the registration form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert the new user into the database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        // Registration successful, set a success message for redirect
        $_SESSION['registration_success'] = true;
        header("Location: login.php");
        exit();
    } else {
        // If registration fails, set an error message
        $_SESSION['registration_error'] = true;
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
    <title>Daftar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include SweetAlert script -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        body {
            background-image: url('anime.jpeg');
            /* Ganti dengan path background image Anda */
            background-size: cover;
            background-position: center;
        }

        .backdrop {
            backdrop-filter: blur(5px);
            background-color: rgba(0, 0, 0, 0.5);
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            background-color: white;
            color: #333;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            outline: none;
        }

        .button {
            width: 100%;
            padding: 10px;
            background-color: #FFA500;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #FF7C00;
        }

        .link {
            color: #FFA500;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .link:hover {
            color: #FF7C00;
        }
    </style>
</head>

<body>
    <div class="backdrop p-8 rounded-xl shadow-lg w-full max-w-md mx-auto mt-20">
        <h2 class="text-white text-3xl font-bold mb-6 text-center">Daftar</h2>
        <form method="post">
            <div class="mb-4">
                <input type="text" name="username" placeholder="Username" class="form-input">
            </div>
            <div class="mb-4">
                <input type="email" name="email" placeholder="Email" class="form-input">
            </div>
            <div class="mb-4 relative">
                <input type="password" name="password" placeholder="Password" class="form-input" id="password">
                <button type="button" class="absolute right-4 top-3" id="togglePassword">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            <button type="submit" class="button">Daftar</button>
        </form>
        <p class="text-white text-center mt-4">Sudah memiliki akun? <a href="login.php" class="link">Masuk</a></p>
        <div class="text-center mt-4">
            <a href="index.php" class="link">Kembali ke home</a>
        </div>
    </div>
    <script>
        // Toggle password visibility
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
        }); // Check for registration success or error and show corresponding SweetAlert
        <?php if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) : ?>
            swal.fire({
                icon: 'success',
                title: 'Registrasi Berhasil!',
                text: 'Anda telah berhasil mendaftar.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'login.php';
            });
            <?php unset($_SESSION['registration_success']); ?>
        <?php elseif (isset($_SESSION['registration_error']) && $_SESSION['registration_error']) : ?>
            swal.fire({
                icon: 'error',
                title: 'Registrasi Gagal!',
                text: 'Pendaftaran tidak berhasil. Silakan coba lagi.',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['registration_error']); ?>
        <?php endif; ?>
    </script>
</body>

</html>