<?php
session_start(); // Mulai sesi untuk mengakses informasi login

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login setelah logout
header("Location: index.php");
exit();
