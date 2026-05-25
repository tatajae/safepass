/* =========================
   GENERATE PASSWORD
========================= */

/* =========================
   GENERATE PASSWORD
========================= */

function generatePassword(){

    const length =
        document.getElementById(
            'length'
        ).value;

    const uppercase =
        document.getElementById(
            'uppercase'
        ).checked;

    const lowercase =
        document.getElementById(
            'lowercase'
        ).checked;

    const number =
        document.getElementById(
            'number'
        ).checked;

    const symbol =
        document.getElementById(
            'symbol'
        ).checked;

    let chars = "";

    if(uppercase){

        chars += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    }

    if(lowercase){

        chars += "abcdefghijklmnopqrstuvwxyz";
    }

    if(number){

        chars += "0123456789";
    }

    if(symbol){

        chars += "!@#$%^&*()_+{}[]<>?";
    }

    if(chars === ""){

        alert(
            "Pilih minimal 1 opsi"
        );

        return;
    }

    let password = "";

    /* CSPRNG */

    const randomValues =
        new Uint32Array(length);

    crypto.getRandomValues(
        randomValues
    );

    for(let i = 0; i < length; i++){

        password += chars.charAt(

            randomValues[i] %
            chars.length

        );
    }

    document.getElementById(
        'resultPassword'
    ).value = password;

    checkStrength(password);
}

/* =========================
   COPY PASSWORD
========================= */

function copyPassword(){

    const password =
        document.getElementById(
            'resultPassword'
        );

    if(password.value === ""){

        alert(
            "Generate password dulu"
        );

        return;
    }

    navigator.clipboard.writeText(
        password.value
    );

    alert(
        "Password berhasil dicopy"
    );
}

/* =========================
   CHECK STRENGTH
========================= */

function checkStrength(password){

    const strengthText =
        document.getElementById(
            'strengthText'
        );

    const strengthFill =
        document.getElementById(
            'strengthFill'
        );

    const uppercase =
        document.getElementById(
            'uppercase'
        ).checked;

    const lowercase =
        document.getElementById(
            'lowercase'
        ).checked;

    const number =
        document.getElementById(
            'number'
        ).checked;

    const symbol =
        document.getElementById(
            'symbol'
        ).checked;

    let total = 0;

    if(uppercase)
        total++;

    if(lowercase)
        total++;

    if(number)
        total++;

    if(symbol)
        total++;

    /* WEAK */

    if(total <= 1){

        strengthText.innerHTML =
            "Strength : Weak";

        strengthText.style.color =
            "#ef4444";

        strengthFill.style.width =
            "33%";

        strengthFill.style.background =
            "#ef4444";
    }

    /* MEDIUM */

    else if(total <= 3){

        strengthText.innerHTML =
            "Strength : Medium";

        strengthText.style.color =
            "#f59e0b";

        strengthFill.style.width =
            "66%";

        strengthFill.style.background =
            "#f59e0b";
    }

    /* STRONG */

    else{

        strengthText.innerHTML =
            "Strength : Strong";

        strengthText.style.color =
            "#22c55e";

        strengthFill.style.width =
            "100%";

        strengthFill.style.background =
            "#22c55e";
    }
}