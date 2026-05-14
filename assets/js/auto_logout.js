let logoutTimer;

// Reset timer setiap ada aktivitas user
function resetTimer() {

    clearTimeout(logoutTimer);

    logoutTimer = setTimeout(() => {

        alert('Session expired. Anda akan logout otomatis.');

        // Hancurkan session PHP
        window.location.href = '../API/logout.php';

    }, 300000); // 5 menit
}

// Jalankan timer saat halaman dibuka
window.onload = resetTimer;

// Deteksi aktivitas user
document.onmousemove = resetTimer;
document.onkeydown = resetTimer;
document.onclick = resetTimer;
document.onscroll = resetTimer;