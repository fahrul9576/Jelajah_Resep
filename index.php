<?php
include "base_head.php";
include "header.php"; 
?>

<script>
    $(document).ready(function() {
        // Add smooth scrolling to all links
        $("a").on('click', function(event) {

            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function() {

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
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
