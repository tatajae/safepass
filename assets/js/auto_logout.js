let logoutTimer;

function startTimer() {

    logoutTimer = setTimeout(() => {

        alert("Session habis");

        window.location = "../index.php";

    }, 1 * 60 * 1000);
}

/* reset hanya kalau ada aktivitas BESAR */
function resetTimer() {

    clearTimeout(logoutTimer);
    startTimer();
}

/* pakai event yang lebih ringan */
document.addEventListener("keydown", resetTimer);
document.addEventListener("click", resetTimer);

/* start pertama */
startTimer();