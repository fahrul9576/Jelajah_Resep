<?php
// Mulai sesi
session_start();

// Jika pengguna belum login, user di alihkan ke halaman login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1d4ed8;
        }

        .bg-primary {
            background-color: var(--primary-color);
        }

        .text-primary {
            color: var(--primary-color);
        }
    </style>
</head>

<body class="flex">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-800 text-white h-screen">
        <div class="p-4 font-bold text-xl">
            Jelajah Resep
        </div>
        <nav class="mt-1">
            <a href="#" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700" onclick="loadSection('dashboard')">
                <i class="fas fa-chart-line mr-2"></i> <!-- Icon -->
                Dashboard
            </a>
            <a href="#" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700" onclick="loadSection('manage_users')">
                <i class="fas fa-users mr-2"></i> <!-- Icon -->
                Manajemen User
            </a>
            <a href="#" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700" onclick="loadSection('manage_recipes')">
                <i class="fas fa-book mr-2"></i> <!-- Icon -->
                Manajemen Resep
            </a>
            <a href="#" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700" onclick="loadSection('settings')">
                <i class="fas fa-cog mr-2"></i> <!-- Icon -->
                Setting
            </a>
            <a href="logout.php" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                <i class="fas fa-sign-out-alt mr-2"></i> <!-- Icon -->
                Logout
            </a>
        </nav>

    </div>
    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100" id="main-content">
        <?php include 'dashboard.php'; ?>
    </div>
    <script src="js/script.js"></script>
</body>

</html>