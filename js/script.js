function loadSection(section) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', section + '.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('main-content').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
function deleteUser(userId) {
    if (confirm("Apakah Anda yakin ingin menghapus pengguna ini?")) {
        // Lakukan AJAX request untuk menghapus pengguna
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_user.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status == 200) {
                // Handle response jika diperlukan
                console.log(xhr.responseText);
                // Reload halaman atau lakukan operasi lain setelah penghapusan berhasil
                window.location.reload();
            } else {
                // Handle kesalahan jika diperlukan
                console.error('Terjadi kesalahan ketika menghapus pengguna');
            }
        }
        xhr.send('user_id=' + userId);
    }
}

