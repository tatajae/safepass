async function saveVault() {

  const website =
    document.getElementById('website').value;

  const username =
    document.getElementById('username').value;

  const password =
    document.getElementById('password').value;

  const masterPassword = prompt(
    'Masukkan Master Password'
  );

  const encrypted = await encryptData(
    password,
    masterPassword
  );

  const response = await fetch(
    '../api/save_vault.php',
    {
      method: 'POST',

      headers: {
        'Content-Type': 'application/json'
      },

      body: JSON.stringify({

        website,
        username,

        ciphertext:
          encrypted.ciphertext,

        iv:
          encrypted.iv,

        salt:
          encrypted.salt

      })
    }
  );

  const data = await response.json();

  document.getElementById(
    'result'
  ).innerHTML = data.message;
}