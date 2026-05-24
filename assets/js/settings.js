async function saveSettings(){

    const oldPassword =
    document.getElementById(
    "old_password"
    ).value;

    const newPassword =
    document.getElementById(
    "new_password"
    ).value;

    const confirmPassword =
    document.getElementById(
    "confirm_password"
    ).value;

    if(
        oldPassword === "" ||
        newPassword === "" ||
        confirmPassword === ""
    ){

        alert(
        "Semua field wajib diisi"
        );

        return;
    }

    if(
        newPassword !== confirmPassword
    ){

        alert(
        "Konfirmasi password tidak cocok"
        );

        return;
    }

    try{

        /* GET USER EMAIL */
        const email =
        sessionStorage.getItem(
        "email"
        );

        /* GET SALT */
        const saltResponse =
        await fetch(

        `../api/get_salt.php?email=${encodeURIComponent(email)}`

        );

        const saltData =
        await saltResponse.json();

        if(!saltData.success){

            alert(
            "User tidak ditemukan"
            );

            return;
        }

        /* GENERATE AUTH VERIFIER */

        const oldAuthVerifier =

        await deriveAuthVerifier(

            oldPassword,
            saltData.salt

        );

        const newAuthVerifier =

        await deriveAuthVerifier(

            newPassword,
            saltData.salt

        );

        /* UPDATE */

        const response =
        await fetch(

        "../api/update_password.php",

        {

        method:"POST",

        headers:{
            "Content-Type":
            "application/json"
        },

        body:JSON.stringify({

            oldAuthVerifier:
            oldAuthVerifier,

            newAuthVerifier:
            newAuthVerifier

        })

        }

        );

        const data =
        await response.json();

        alert(
        data.message
        );

        if(data.success){

            resetSettings();
        }

    }catch(err){

        console.log(err);

        alert(
        "Gagal update password"
        );
    }
}