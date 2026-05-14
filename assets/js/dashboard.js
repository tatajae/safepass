// dashboard.js

let selectedCipher = '';
let selectedIv = '';
let selectedSalt = '';

/*
|--------------------------------------------------------------------------
| SAVE VAULT
|--------------------------------------------------------------------------
*/

async function saveVault(){

    const website =
        document.getElementById(
            'website'
        ).value.trim();

    const username =
        document.getElementById(
            'username'
        ).value.trim();

    const password =
        document.getElementById(
            'password'
        ).value;

    if(
        website === '' ||
        username === '' ||
        password === ''
    ){

        alert(
            'Semua field wajib diisi'
        );

        return;
    }

    const masterPassword =
        document.getElementById(
            'masterPassword'
        ).value;

    if(masterPassword === ''){

        alert(
            'Masukkan master password'
        );

        return;
    }

    try{

        const encrypted =
            await encryptData(
                password,
                masterPassword
            );

        const response =
            await fetch(
                '../api/save_vault.php',
                {
                    method: 'POST',

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

    }catch(error){

        alert(
            'Gagal menyimpan vault'
        );
    }
}

/*
|--------------------------------------------------------------------------
| GENERATE PASSWORD
|--------------------------------------------------------------------------
*/

function generatePassword(){

    const chars =
        'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$%^&*';

    let password = '';

    for(let i = 0; i < 16; i++){

        password += chars.charAt(
            Math.floor(
                Math.random() *
                chars.length
            )
        );
    }

    document.getElementById(
        'password'
    ).value = password;

    checkStrength();
}

/*
|--------------------------------------------------------------------------
| OPEN MODAL
|--------------------------------------------------------------------------
*/

function openDecryptModal(btn){

    selectedCipher =
        btn.dataset.cipher;

    selectedIv =
        btn.dataset.iv;

    selectedSalt =
        btn.dataset.salt;

    const modal =
        new bootstrap.Modal(
            document.getElementById(
                'decryptModal'
            )
        );

    modal.show();
}

/*
|--------------------------------------------------------------------------
| DECRYPT PASSWORD
|--------------------------------------------------------------------------
*/

async function decryptVault(){

    const masterPassword =
        document.getElementById(
            'masterPassword'
        ).value;

    if(masterPassword === ''){

        alert(
            'Masukkan master password'
        );

        return;
    }

    try{

        const decrypted =
            await decryptData(
                selectedCipher,
                selectedIv,
                selectedSalt,
                masterPassword
            );

        document.getElementById(
            'decryptResult'
        ).innerHTML = `

            <div class="alert alert-success">

                <strong>Password:</strong>
                ${decrypted}

            </div>

        `;

    }catch(error){

        document.getElementById(
            'decryptResult'
        ).innerHTML = `

            <div class="alert alert-danger">

                Master password salah

            </div>

        `;
    }
}

/*
|--------------------------------------------------------------------------
| COPY PASSWORD
|--------------------------------------------------------------------------
*/

async function copyPassword(btn){

    const ciphertext =
        btn.dataset.cipher;

    const iv =
        btn.dataset.iv;

    const salt =
        btn.dataset.salt;

    const masterPassword =
        prompt(
            'Masukkan master password'
        );

    if(!masterPassword) return;

    try{

        const decrypted =
            await decryptData(
                ciphertext,
                iv,
                salt,
                masterPassword
            );

        await navigator.clipboard.writeText(
            decrypted
        );

        alert(
            'Password berhasil dicopy'
        );

    }catch(error){

        alert(
            'Master password salah'
        );
    }
}

/*
|--------------------------------------------------------------------------
| DELETE VAULT
|--------------------------------------------------------------------------
*/

async function deleteVault(id){

    const confirmDelete =
        confirm(
            'Hapus password ini?'
        );

    if(!confirmDelete) return;

    const response =
        await fetch(
            '../api/delete_vault.php',
            {
                method: 'POST',

                headers:{
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

/*
|--------------------------------------------------------------------------
| EDIT VAULT
|--------------------------------------------------------------------------
*/

function editVault(
    id,
    website,
    username
){

    window.editId = id;

    document.getElementById(
        'website'
    ).value = website;

    document.getElementById(
        'username'
    ).value = username;
}

/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

function searchVault(){

    const input =
        document
        .getElementById(
            'search'
        )
        .value
        .toLowerCase();

    const rows =
        document.querySelectorAll(
            '.table-row'
        );

    rows.forEach(row => {

        const text =
            row.innerText.toLowerCase();

        row.style.display =
            text.includes(input)
            ? 'grid'
            : 'none';
    });
}

/*
|--------------------------------------------------------------------------
| TOGGLE PASSWORD
|--------------------------------------------------------------------------
*/

function togglePassword(){

    const password =
        document.getElementById(
            'password'
        );

    if(password.type === 'password'){

        password.type = 'text';

    }else{

        password.type = 'password';
    }
}

/*
|--------------------------------------------------------------------------
| PASSWORD STRENGTH
|--------------------------------------------------------------------------
*/

function checkStrength(){

    const password =
        document.getElementById(
            'password'
        ).value;

    const strength =
        document.getElementById(
            'strength'
        );

    if(password.length < 6){

        strength.innerHTML =
            '<span style="color:red">Weak</span>';

    }else if(password.length < 10){

        strength.innerHTML =
            '<span style="color:orange">Medium</span>';

    }else{

        strength.innerHTML =
            '<span style="color:lime">Strong</span>';
    }
}

/*
|--------------------------------------------------------------------------
| CLEAR FORM
|--------------------------------------------------------------------------
*/

function clearForm(){

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
        'strength'
    ).innerHTML = '';
}