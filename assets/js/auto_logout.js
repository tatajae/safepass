let timeout;

function resetTimer() {
    clearTimeout(timeout);

    timeout = setTimeout(() => {
        alert("Session expired. Auto logout.");

        window.location.href = "logout.php";
    }, 300000);
}

window.onload = resetTimer;

document.onmousemove = resetTimer;
document.onkeypress = resetTimer;
document.onclick = resetTimer;