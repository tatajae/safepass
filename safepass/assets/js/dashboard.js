async function saveVault(){

  const website =
    document.getElementById(
      'website'
    ).value;

  const username =
    document.getElementById(
      'username'
    ).value;

  const password =
    document.getElementById(
      'password'
    ).value;

  if(window.editId){

    await fetch(
      '../api/edit_vault.php',
      {
        method: 'POST',

        headers:{
          'Content-Type':
          'application/json'
        },

        body: JSON.stringify({

          id: window.editId,

          website,

          username
        })
      }
    );

    alert('Vault berhasil diupdate');

    location.reload();

    return;
  }

  const masterPassword = prompt(
    'Masukkan master password'
  );

  const encrypted =
    await encryptData(
      password,
      masterPassword
    );

  const response = await fetch(
    '../api/save_vault.php',
    {
      method:'POST',

      headers:{
        'Content-Type':
        'application/json'
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

  const data =
    await response.json();

  alert(data.message);

  location.reload();
}

function clearForm() {

  document.getElementById(
    'website'
  ).value = '';

  document.getElementById(
    'username'
  ).value = '';

  document.getElementById(
    'password'
  ).value = '';

  document.getElementById(
    'result'
  ).innerHTML = '';
}

function generatePassword() {

  const chars =
    'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$';

  let password = '';

  for (let i = 0; i < 12; i++) {

    password += chars.charAt(
      Math.floor(
        Math.random() * chars.length
      )
    );
  }

  document.getElementById(
    'password'
  ).value = password;
}

async function viewPassword(
  ciphertext,
  iv,
  salt
) {

  alert(
    'Decrypt password disini'
  );
}

async function deleteVault(id) {

  const confirmDelete =
    confirm(
      'Hapus password ini?'
    );

  if (!confirmDelete) return;

  const response = await fetch(
    '../api/delete_vault.php',
    {
      method: 'POST',

      headers: {
        'Content-Type':
          'application/json'
      },

      body: JSON.stringify({
        id
      })
    }
  );

  const data =
    await response.json();

  alert(data.message);

  location.reload();
}

async function editVault(
  id,
  website,
  username
) {

  document.getElementById(
    'website'
  ).value = website;

  document.getElementById(
    'username'
  ).value = username;

  document.getElementById(
    'result'
  ).innerHTML = `

    <button
      onclick="updateVault(${id})"
      class="save-btn"
    >
      Update Password
    </button>

  `;
}

async function updateVault(id) {

  const website =
    document.getElementById('website').value;

  const username =
    document.getElementById('username').value;

  const password =
    document.getElementById('password').value;

  const encrypted =
    await encryptData(
      password,
      'masterkey123'
    );

  const response = await fetch(
    '../api/update_vault.php',
    {
      method: 'POST',

      headers: {
        'Content-Type':
          'application/json'
      },

      body: JSON.stringify({

        id,
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

  const data =
    await response.json();

  alert(data.message);

  location.reload();
}
function searchVault(){

  const input =
    document
    .getElementById('search')
    .value
    .toLowerCase();

  const rows =
    document.querySelectorAll('.table-row');

  rows.forEach(row => {

    const text =
      row.innerText.toLowerCase();

    row.style.display =
      text.includes(input)
      ? 'grid'
      : 'none';
  });
}

async function copyPassword(
  ciphertext,
  iv,
  salt
){

  const password = prompt(
    'Masukkan master password'
  );

  try{

    const decrypted =
      await decryptData(
        ciphertext,
        iv,
        salt,
        password
      );

    navigator.clipboard.writeText(
      decrypted
    );

    alert(
      'Password berhasil dicopy'
    );

  }catch{

    alert('Password salah');
  }
}

function toggleDarkMode(){

  document.body.classList.toggle(
    'dark-mode'
  );

  localStorage.setItem(
    'darkMode',
    document.body.classList.contains(
      'dark-mode'
    )
  );
}

window.onload = () => {

  const dark =
    localStorage.getItem('darkMode');

  if(dark === 'true'){

    document.body.classList.add(
      'dark-mode'
    );
  }
}