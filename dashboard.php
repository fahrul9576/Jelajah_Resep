<?php // Mulai sesi untuk mengakses informasi login
include "base_head.php";
include "header.php";
// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika tidak, redirect ke halaman login
    header("Location: login.php");
    exit();
}



// Ambil informasi pengguna dari sesi
$user_id = $_SESSION['user_id'];
$user_nama = $_SESSION['username'];
?>
<script>
    $(document).ready(function() {
        $("a").on('click', function(event) {
            if (this.hash !== "") {
                event.preventDefault();
                var hash = this.hash;
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function() {
                    window.location.hash = hash;
                });
            } 
        });
    });
</script>
<style>
    /* CSS untuk navbar yang sticky */
    .sticky {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
        /* Sesuaikan dengan kebutuhan Anda */
        background-color: white;
        /* Sesuaikan dengan warna background yang diinginkan */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        /* Optional: tambahkan shadow untuk efek visual */
    }

    html {
        scroll-behavior: smooth;
    }

    .custom-background {
        background-color: rgba(0, 0, 0, 0.1);
        /* Black transparent background */
        border-radius: 50%;
        /* Rounded border */
    }

    .slider {
        position: relative;
        overflow: hidden;
        top: 10px;
    }

    .slide {
        min-width: 100%;
        transition: transform 0.5s ease-in-out;
    }

    .slider-wrapper {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    /* Tambahkan di stylesheet CSS Anda atau di bagian <style> */
</style>

<body class="bg-gray-100">

    <!-- Slider -->
    <h1 class="font-bold text-4xl text-gray-700 mt-10 mb-8 ml-10">Selamat Datang, <?php echo $user_nama; ?></h1>

    <div id="slider" class="slider w-full max-w-2xl mx-auto rounded-xl mt-8">
        <div class="slider-wrapper">
            <!-- ukuran gambar nya itu bang 800x400 -->
            <img src="https://picsum.photos/800/400" alt="Slide 1" class="slide">
            <img src="https://picsum.photos/800/400" alt="Slide 2" class="slide">
            <img src="https://picsum.photos/800/400" alt="Slide 3" class="slide">
        </div>
        <button onclick="prevSlide()" style="justify-content: center; align-items: center;" class="absolute top-1/2 transform -translate-y-1/2 left-4  text-white px-3 py-2">
            <i class="fa fa-angle-left custom-background text-white p-4"></i>
            <button onclick="nextSlide()" class="absolute top-1/2 transform -translate-y-1/2 right-4  text-white px-3 py-2">
                <i class="fa fa-angle-right custom-background text-white p-4"></i>
            </button>
    </div>

    <!-- Kategori 1 -->
    <section id="resep" class="flex items-center justify-center mt-10">
        <div class="container mx-auto px-5 py-10">
            <h2 class="text-3xl font-bold mb-4 text-center">Kategori</h2>
            <div class="grid grid-cols-5 gap-4">
                <!-- Gambar 1-5 -->
                <div class="flex flex-col items-center">
                    <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden">
                        <img src="https://picsum.photos/400/300" alt="Gambar 1" class="object-cover w-full h-full">
                    </div>
                    <p class="text-center mt-2">Teks di bawah gambar 1</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden">
                        <img src="https://picsum.photos/400/300" alt="Gambar 2" class="object-cover w-full h-full">
                    </div>
                    <p class="text-center mt-2">Teks di bawah gambar 2</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden">
                        <img src="https://picsum.photos/400/300" alt="Gambar 3" class="object-cover w-full h-full">
                    </div>
                    <p class="text-center mt-2">Teks di bawah gambar 3</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden">
                        <img src="https://picsum.photos/400/300" alt="Gambar 4" class="object-cover w-full h-full">
                    </div>
                    <p class="text-center mt-2">Teks di bawah gambar 4</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden">
                        <img src="https://picsum.photos/400/300" alt="Gambar 5" class="object-cover w-full h-full">
                    </div>
                    <p class="text-center mt-2">Teks di bawah gambar 5</p>
                </div>
                <!-- Gambar 6-10 -->
                <div class="flex flex-col items-center">
                    <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden">
                        <img src="https://picsum.photos/400/300" alt="Gambar 6" class="object-cover w-full h-full">
                    </div>
                    <p class="text-center mt-2">Teks di bawah gambar 6</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden">
                        <img src="https://picsum.photos/400/300" alt="Gambar 7" class="object-cover w-full h-full">
                    </div>
                    <p class="text-center mt-2">Teks di bawah gambar 7</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden">
                        <img src="https://picsum.photos/400/300" alt="Gambar 8" class="object-cover w-full h-full">
                    </div>
                    <p class="text-center mt-2">Teks di bawah gambar 8</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden">
                        <img src="https://picsum.photos/400/300" alt="Gambar 9" class="object-cover w-full h-full">
                    </div>
                    <p class="text-center mt-2">Teks di bawah gambar 9</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden">
                        <img src="https://picsum.photos/400/300" alt="Gambar 10" class="object-cover w-full h-full">
                    </div>
                    <p class="text-center mt-2">Teks di bawah gambar 10</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Section 2 -->
    <section>
        <div class="container mx-auto p-10">
            <h2 class="text-3xl font-bold mb-4 text-center">Resep Of The Day</h2>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row gap-4">
                <img src="https://img-global.cpcdn.com/recipes/6a7e355252154e9b/1360x964cq70/463-soto-ayam-segar-foto-resep-utama.webp" alt="Ayam Kuah Segar" class="w-full md:w-1/2">
                <div class="p-4 w-full md:w-1/2 flex flex-col justify-center">
                    <h2 class="text-2xl font-bold text-orange-500 mb-2 text-center md:text-left">Menu Kaya Nutrisi Ala Kamu
                    </h2>
                    <p class="text-gray-700 mb-4 text-center md:text-left">Published by: Putri Habibie</p>
                    <h3 class="text-xl font-bold mb-2 text-center md:text-left">Ayam Kuah Segar</h3>
                    <p class="text-gray-700 text-center md:text-left">Resep ayam kuah segar adalah menu andalan yang mudah
                        dibuat untuk sahur bersama
                        keluarga. Kuahnya yang segar dan hangat membuat saya dan keluarga bersemangat...</p>
                    <div class="mt-4 flex justify-center md:justify-start gap-4">
                        <button class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-full">Lihat
                            Resep Lainnya</button>
                        <button class="bg-white hover:bg-gray-100 text-orange-500 font-bold py-2 px-4 rounded-full">Unggah
                            Resepmu</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section 3 -->
    <section id="tentang-kami" class="bg-gradient-to-b  py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-extrabold text-center mb-8 text-yellow-800">Selamat Datang di Jelajah Resep</h2>
            <p class="text-lg text-gray-800 leading-relaxed">
                Temukan kelezatan dunia dalam setiap suapan! Di Jelajah Resep, kami tidak hanya menyajikan resep-resep makanan terbaik dari berbagai belahan dunia, tetapi juga mengajak Anda dalam petualangan kuliner yang tak terlupakan. Dengan campuran rahasia dari para koki berpengalaman, kami memberikan Anda panduan langkah demi langkah untuk menghadirkan hidangan lezat di meja makan Anda.
            </p>
            <p class="text-lg text-gray-800 mt-4 leading-relaxed">
                Dari sajian tradisional hingga kreasi modern yang inovatif, kami menyediakan inspirasi tak terbatas untuk menjadikan masak-memasak sebagai momen menyenangkan yang dapat Anda nikmati bersama keluarga dan teman-teman tercinta. Mari bersama-sama menjelajahi dunia rasa dan menciptakan kenangan indah melalui makanan!
            </p>
        </div>
    </section>

    <?php
    include 'footer.php';
    ?>



    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const target = document.querySelector(this.getAttribute('href'));

                window.scrollTo({
                    top: target.offsetTop,
                    behavior: 'smooth'
                });
            });
        });
    </script>

    <script>
        let currentIndex = 0;

        function showSlide(index) {
            const slides = document.querySelectorAll('.slide');
            const totalSlides = slides.length;
            const sliderWrapper = document.querySelector('.slider-wrapper');

            if (index >= totalSlides) {
                currentIndex = 0;
            } else if (index < 0) {
                currentIndex = totalSlides - 1;
            } else {
                currentIndex = index;
            }

            sliderWrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        function nextSlide() {
            showSlide(currentIndex + 1);
        }

        function prevSlide() {
            showSlide(currentIndex - 1);
        }

        // Auto-slide (optional)
        setInterval(nextSlide, 3000);
    </script>
</body>

</html>