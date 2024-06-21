<?php
// Mulai sesi
session_start();

// Hapus semua sesi
session_unset();
session_destroy();

// Redirect ke halaman login (misalnya)
header("Location: login.php");
exit();
