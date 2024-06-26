<?php
$url = isset($_GET['url']) ? $_GET['url'] : '';

if ($url) {
    // Inisialisasi cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    // Ambil konten gambar
    $image = curl_exec($ch);
    curl_close($ch);

    // Tentukan tipe konten gambar
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $type = finfo_buffer($finfo, $image);
    finfo_close($finfo);

    // Set header tipe konten dan tampilkan gambar
    header("Content-Type: $type");
    echo $image;
} else {
    header("HTTP/1.0 400 Bad Request");
    echo "No image URL provided.";
}
