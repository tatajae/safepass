// assets/js/generator.js

function generatePassword(){

  const length =
    document.getElementById('length').value;

  const uppercase =
    document.getElementById('uppercase').checked;

  const lowercase =
    document.getElementById('lowercase').checked;

  const number =
    document.getElementById('number').checked;

  const symbol =
    document.getElementById('symbol').checked;

  let chars = "";

  /* CHARACTER OPTIONS */

  if (uppercase)
    chars += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

  if (lowercase)
    chars += "abcdefghijklmnopqrstuvwxyz";

  if (number)
    chars += "0123456789";

  if (symbol)
    chars += "!@#$%^&*()_+{}[]<>?/";

  /* VALIDASI */

  if(chars.length === 0){

    alert("Pilih minimal 1 opsi");

    return;
  }

  /* GENERATE */

  let password = "";

  for(let i = 0; i < length; i++){

    password += chars.charAt(
      Math.floor(Math.random() * chars.length)
    );
  }

  document.getElementById(
    'resultPassword'
  ).value = password;

  checkStrength(password);
}

/* COPY PASSWORD */

function copyPassword(){

  const password =
    document.getElementById(
      'resultPassword'
    );

  if(password.value === ""){

    alert("Generate password dulu");

    return;
  }

  navigator.clipboard.writeText(
    password.value
  );

  alert("Password berhasil dicopy");
}

/* PASSWORD STRENGTH */

function checkStrength(password){

  const strengthText =
    document.getElementById(
      'strength'
    );

  const strengthFill =
    document.getElementById(
      'strengthFill'
    );

  let score = 0;

  /* KRITERIA */

  if(password.length >= 8)
    score++;

  if(/[A-Z]/.test(password))
    score++;

  if(/[a-z]/.test(password))
    score++;

  if(/[0-9]/.test(password))
    score++;

  if(/[\W]/.test(password))
    score++;

  /* WEAK */

  if(score <= 2){

    strengthText.innerHTML =
      "Strength : Weak";

    strengthText.style.color =
      "#dc2626";

    strengthFill.style.width =
      "33%";

    strengthFill.style.background =
      "#dc2626";
  }

  /* MEDIUM */

  else if(score <= 4){

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
      "#16a34a";

    strengthFill.style.width =
      "100%";

    strengthFill.style.background =
      "#16a34a";
  }
}