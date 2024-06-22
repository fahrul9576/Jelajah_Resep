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
        // Lakukan request dengan menggunakan fetch API
        fetch('delete_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'user_id': userId
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Terjadi kesalahan ketika menghapus pengguna');
                }
                return response.text();
            })
            .then(data => {
                console.log(data);
                // Reload halaman atau lakukan operasi lain setelah penghapusan berhasil
                window.location.reload();
            })
            .catch(error => {
                // Handle kesalahan jika diperlukan
                console.error(error);
            });
    }
}

function showEditForm(userId, currentUsername, currentEmail) {
    document.getElementById('editUserId').value = userId;
    document.getElementById('editUsername').value = currentUsername;
    document.getElementById('editEmail').value = currentEmail;
    document.getElementById('editFormModal').classList.remove('hidden');
}

function editUser() {
    const userId = document.getElementById('editUserId').value;
    const username = document.getElementById('editUsername').value;
    const email = document.getElementById('editEmail').value;

    if (username && email) {
        fetch('edit_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'user_id': userId,
                'username': username,
                'email': email
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Terjadi kesalahan ketika mengedit pengguna');
                }
                return response.text();
            })
            .then(data => {
                console.log(data);
                window.location.reload();
            })
            .catch(error => {
                console.error(error);
            });
    } else {
        alert("Username dan email tidak boleh kosong");
    }
}

function closeEditForm() {
    document.getElementById('editFormModal').classList.add('hidden');
}

function deleteRecipe(idResep) {
    if (confirm("Apakah Anda yakin ingin menghapus resep ini?")) {
        fetch('delete_resep.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'id_resep': idResep
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Terjadi kesalahan ketika menghapus resep');
                }
                return response.text();
            })
            .then(data => {
                console.log(data);
                window.location.reload();
            })
            .catch(error => {
                console.error(error);
            });
    }
}
