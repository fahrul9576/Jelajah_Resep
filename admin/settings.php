<div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Settings</h2>
    <form id="settings-form">
        <div class="mb-4">
            <h3 class="text-lg font-bold mb-2">Theme</h3>
            <div class="flex items-center mb-2">
                <input type="radio" id="theme-light" name="theme" value="light" class="mr-2" checked>
                <label for="theme-light">Light</label>
            </div>
            <div class="flex items-center mb-2">
                <input type="radio" id="theme-dark" name="theme" value="dark" class="mr-2">
                <label for="theme-dark">Dark</label>
            </div>
        </div>
        <div class="mb-4">
            <h3 class="text-lg font-bold mb-2">Font Size</h3>
            <input type="range" id="font-size" name="font-size" min="12" max="24" class="w-full">
        </div>
        <button type="submit" id="save-settings" class="bg-primary text-white py-2 px-4 rounded">Save</button>
    </form>
</div>

<script>
    document.getElementById('settings-form').addEventListener('submit', function(e) {
        e.preventDefault();
        // Mengambil nilai tema yang dipilih
        var theme = document.querySelector('input[name="theme"]:checked').value;
        // Mengambil nilai ukuran font
        var fontSize = document.getElementById('font-size').value;

        // Simpan preferensi ke localStorage
        localStorage.setItem('theme', theme);
        localStorage.setItem('font-size', fontSize);

        // Tampilkan pesan sukses atau lakukan operasi lainnya
        alert('Settings saved successfully!');
    });
</script>