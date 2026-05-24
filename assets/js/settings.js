async function saveSettings(){

    const old_password =
        document.getElementById(
            'old_password'
        ).value;

    const new_password =
        document.getElementById(
            'new_password'
        ).value;

    const confirm_password =
        document.getElementById(
            'confirm_password'
        ).value;

    if(
        old_password === "" ||
        new_password === "" ||
        confirm_password === ""
    ){

        alert("Semua field wajib diisi");

        return;
    }

    if(new_password !== confirm_password){

        alert("Konfirmasi password tidak cocok");

        return;
    }

    try{

        const email =
            sessionStorage.getItem(
                'email'
            );

        /* GET SALT */
        const saltResponse =
            await fetch(
                `../api/get_salt.php?email=${encodeURIComponent(email)}`
            );

        const saltData =
            await saltResponse.json();

        if(!saltData.success){

            alert("User tidak ditemukan");

            return;
        }

        /* VERIFY OLD PASSWORD */
        const oldVerifier =
            await deriveAuthVerifier(
                old_password,
                saltData.salt
            );

        /* LOGIN CHECK */
        const loginResponse =
            await fetch(
                '../api/login.php',
                {

                    method:'POST',

                    headers:{
                        'Content-Type':
                        'application/json'
                    },

                    body: JSON.stringify({

                        email,
                        authVerifier:
                        oldVerifier

                    })
                }
            );

        const loginData =
            await loginResponse.json();

        if(!loginData.success){

            alert("Password lama salah");

            return;
        }

        /* NEW VERIFIER */
        const newVerifier =
            await deriveAuthVerifier(
                new_password,
                saltData.salt
            );

        /* UPDATE PASSWORD */
        const response =
            await fetch(
                '../api/update_password.php',
                {

                    method:'POST',

                    headers:{
                        'Content-Type':
                        'application/json'
                    },

                    body: JSON.stringify({

                        new_auth_verifier:
                        newVerifier

                    })
                }
            );

        const data =
            await response.json();

        alert(data.message);

    }catch(err){

        console.error(err);

        alert("Server error");
    }
}

function saveSettings(){

    const sessionTimeout =
        document.getElementById('session_timeout').checked;

    const encryptVault =
        document.getElementById('encrypt_vault').checked;

    const zeroKnowledge =
        document.getElementById('zero_knowledge').checked;

    localStorage.setItem('sessionTimeout', sessionTimeout);
    localStorage.setItem('encryptVault', encryptVault);
    localStorage.setItem('zeroKnowledge', zeroKnowledge);

    alert("Settings disimpan");
}

function toggleDarkMode() {

    document.body.classList.toggle('dark-mode');

    // simpan status
    if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
}

document.addEventListener('DOMContentLoaded', function () {

    const theme = localStorage.getItem('theme');

    if (theme === 'dark') {
        document.body.classList.add('dark-mode');
    }
});

document.addEventListener("DOMContentLoaded", () => {

    document.getElementById('session_timeout').checked =
        localStorage.getItem('sessionTimeout') === "true";

    document.getElementById('encrypt_vault').checked =
        localStorage.getItem('encryptVault') === "true";

    document.getElementById('zero_knowledge').checked =
        localStorage.getItem('zeroKnowledge') === "true";
});