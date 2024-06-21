<?php // Mulai sesi

// Sertakan file base_head.php
include "base_head.php";

// Ambil nilai user_id dari sesi jika tersedia
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>

<style>
    .search-input {
        transition: width 0.5s ease-in-out;
    }

    .search-input:focus {
        width: 300px;
        /* Atur ukuran sesuai kebutuhan */
        padding-left: 2.5rem;
        /* Atur padding kiri */
    }
</style>

<body>
    <header class="bg-white" id="navbar">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="h-8 w-auto">Jelajah Resep</span>
                </a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-center lg:gap-x-12">
                <a href="<?php echo isset($user_id) ? '/Jelajah%20Resep/dashboard.php#resep' : '/Jelajah%20Resep/index.php#resep'; ?>" class="text-sm font-semibold leading-6 text-gray-900">Home</a>
                <a href="<?php echo isset($user_id) ? '/Jelajah%20Resep/dashboard.php#resep' : '/Jelajah%20Resep/#resep'; ?>" class="text-sm font-semibold leading-6 text-gray-900">Resep</a>
                <a href="<?php echo isset($user_id) ? '/Jelajah%20Resep/upload_resep/upload_resep.php' : '/Jelajah%20Resep/upload_resep/upload_resep.php'; ?>" class="text-sm font-semibold leading-6 text-gray-900">Upload Resep</a>

                <a href="<?php echo isset($user_id) ? '/Jelajah%20Resep/dashboard.php#tentang-kami' : '/Jelajah%20Resep/#tentang-kami'; ?>" class="text-sm font-semibold leading-6 text-gray-900">About Us</a>
            </div>

            <!-- Kontainer untuk search bar dan tombol login -->
            <div class="flex items-center gap-x-4 lg:flex lg:flex-1 lg:justify-end">
                <!-- search bar -->
                <div class="relative">
                    <form action="/Jelajah%20Resep/search.php" method="GET" id="search-form" class="relative">
                        <input type="search" name="q" id="search-input" class="peer search-input relative z-10 h-12 w-12 cursor-pointer rounded-full border bg-transparent pl-12 outline-none focus:cursor-text focus:border-gray-300 transition-all duration-500 ease-in-out" />
                        <svg xmlns="http://www.w3.org/2000/svg" id="search-icon" class="absolute inset-y-0 my-auto h-8 w-12 border-r border-transparent stroke-gray-500 px-3.5 peer-focus:border-gray-300 peer-focus:stroke-gray-500 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <button type="submit" style="display: none;"></button> <!-- Tambahkan tombol submit tersembunyi untuk menangani form submission -->
                    </form>
                </div>

                <!-- Tombol login atau menu navigasi pengguna -->
                <?php
                if (isset($user_id)) {
                    // Jika user sudah login
                    echo '<div class="hidden lg:flex relative">';
                    echo '<button id="userMenuBtn" class="text-sm font-semibold leading-1 text-gray-900">';
                    echo '<svg class="h-8 w-8 text-gray-900 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="userMenuIcon">';
                    echo '<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>';
                    echo '</svg>';
                    echo '</button>';
                    // Menu dropdown untuk user yang sudah login
                    echo '<ul id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none" aria-label="submenu">';
                    echo '<li><a href="/Jelajah%20Resep/profile/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a></li>';
                    echo '<li><a href="/Jelajah%20Resep/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a></li>';
                    echo '</ul>';
                    echo '</div>';
                } else {
                    // Jika user belum login
                    echo '<div class="hidden lg:flex">';
                    echo '<a href="login.php" class="text-sm font-semibold leading-1 text-gray-900">Log in <i class="fas fa-user-alt" style="color: orange; font-size: 20px;"></i></a>';
                    echo '</div>';
                }
                ?>
                <!-- Tombol menu mobile (burger) -->
                <div id="burgerMenuBtn" class="lg:hidden">
                    <svg class="h-8 w-8 text-gray-900 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="burgerIcon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </div>
            </div>
        </nav>

        <!-- Mobile menu (burger menu), show/hide based on menu open state -->
        <div id="mobileMenu" class="hidden lg:hidden" role="dialog" aria-modal="true">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div class="fixed inset-0 z-10"></div>
            <div class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">YourCompany</span>
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="" />
                    </a>
                    <button id="closeMobileMenuBtn" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <a href="#slider" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Home</a>
                            <a href="#resep" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Resep</a>
                            <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Upload Resep</a>
                            <a href="#tentang-kami" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">About Us</a>
                        </div>
                        <div class="py-6">
                            <?php
                            // Cek apakah pengguna sudah login atau belum
                            if (isset($user_id)) {
                                // Jika sudah login, tampilkan opsi logout
                                echo '<a href="logout.php" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Logout</a>';
                            } else {
                                // Jika belum login, tampilkan opsi masuk
                                echo '<a href="login.php" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Masuk</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script>
        // Toggle mobile menu
        const burgerMenuBtn = document.getElementById('burgerMenuBtn');
        const closeMobileMenuBtn = document.getElementById('closeMobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        burgerMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        closeMobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
        });

        // Toggle menu dropdown user
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userMenu = document.getElementById('userMenu');

        userMenuBtn.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent event bubbling
            userMenu.classList.toggle('hidden');
        });

        // Tambahkan class 'sticky' saat navbar berada di atas
        window.onscroll = function() {
            myFunction();
        };

        var navbar = document.getElementById("navbar");

        function myFunction() {
            if (window.pageYOffset > 0) {
                navbar.classList.add("sticky");
            } else {
                navbar.classList.remove("sticky");
            }
        }

        // Menangani klik di luar dropdown menu pengguna untuk menutupnya
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const userMenuBtn = document.getElementById('userMenuBtn');

            // Tutup dropdown menu jika diklik di luar menu atau tombol dropdown
            if (!userMenu.contains(event.target) && event.target !== userMenuBtn) {
                userMenu.classList.add('hidden');
            }
        });

        // Animasi search bar
        const searchInput = document.getElementById('search-input');
        const searchIcon = document.getElementById('search-icon');

        searchIcon.addEventListener('click', () => {
            searchInput.focus();
        });

        // Function to handle search form submission
        function handleSearch(event) {
            event.preventDefault(); // Prevent default form submission
            const keyword = document.getElementById('search-input').value.toLowerCase(); // Get the search keyword
            let destinationUrl = ''; // Variable to store the destination URL based on the keyword

            // Define the destination URLs based on the keywords
            switch (keyword) {
                case 'resep':
                    destinationUrl = 'search.php?q=' + encodeURIComponent(keyword); // Redirect to search.php with the keyword
                    break;
                default:
                    // Handle default case if keyword doesn't match any predefined keywords
                    // For example, redirect to a search results page
                    destinationUrl = 'search.php?q=' + encodeURIComponent(keyword); // Change this to the actual URL of your search results page
                    break;
            }

            // Perform the redirection
            window.location.href = destinationUrl;
        }

        // Add event listener to the search form
        document.getElementById('search-form').addEventListener('submit', handleSearch);
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</body>