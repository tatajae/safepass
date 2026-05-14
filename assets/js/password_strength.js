const passwordInput = document.getElementById("password");

passwordInput.addEventListener("input", function () {

    const password = passwordInput.value;

    let score = 0;

    if (password.length >= 8) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[a-z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;

    let text = "";

    if (score <= 2) {
        text = "Weak";
    } else if (score <= 4) {
        text = "Medium";
    } else {
        text = "Strong";
    }

    document.getElementById("strengthText").innerText =
        "Password Strength: " + text;
});