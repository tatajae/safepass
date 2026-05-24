let editId = null;

/* =========================
   SAVE VAULT
========================= */
async function savePassword() {

    const website =
        document.getElementById('website').value.trim();

    const username =
        document.getElementById('username').value.trim();

    const password =
        document.getElementById('password').value.trim();
    /* =========================
    PASSWORD STRENGTH
    ========================= */

    let password_strength = "Weak";

    const hasLength =
        password.length >= 8;

    const hasLower =
        /[a-z]/.test(password);

    const hasUpper =
        /[A-Z]/.test(password);

    const hasNumber =
        /[0-9]/.test(password);

    const hasSymbol =
        /[^A-Za-z0-9]/.test(password);

    let score = 0;

    if(hasLength) score++;
    if(hasLower) score++;
    if(hasUpper) score++;
    if(hasNumber) score++;
    if(hasSymbol) score++;

    if(score >= 5){

        password_strength =
            "Strong";

    }else if(score >= 3){

        password_strength =
            "Medium";
    }
    const notes =
        document.getElementById('notes').value.trim();

    if (!website || !username || !password) {

        alert("Semua field wajib diisi");
        return;
    }

    try {

        const vaultData = {
            website,
            username,
            password,
            notes
        };

        const masterPassword =
            sessionStorage.getItem(
                'masterPassword'
            );

        if (!masterPassword) {

            alert(
                "Session master password hilang"
            );

            window.location =
                "login.php";

            return;
        }

        const encrypted =
            await encryptData(
                masterPassword,
                vaultData
            );

        let apiUrl =
            "../api/save_vault.php";

        if(editId!==null){

            apiUrl =
                "../api/edit_vault.php";
        }
        console.log(password_strength);
        const response =
            await fetch(apiUrl,{

            method:"POST",

            headers:{
                "Content-Type":
                "application/json"
            },

           body: JSON.stringify({

                id: editId,

                website: website,

                username: username,

                password_strength:
                    password_strength,

                encrypted_data:
                    encrypted.encrypted_data,

                iv:
                    encrypted.iv,

                salt:
                    encrypted.salt
            })
        });

        const data =
            await response.json();

        alert(data.message);

        if(data.success){

            editId=null;

            clearForm();

            loadVault();
        }

    }catch(err){

        console.log(err);

        alert(
            "Gagal menyimpan"
        );
    }
}


/* =========================
   LOAD VAULT
========================= */

async function loadVault(){

    try{

        const response =
            await fetch(
                "../api/get_vault.php"
            );

        const data =
            await response.json();

        const vaultContainer =
            document.getElementById(
                "vaultContainer"
            );

        vaultContainer.innerHTML="";

        if(!data.success){

            vaultContainer.innerHTML=`

            <div class="table-row">

                <span>
                Gagal load data
                </span>

            </div>

            `;

            return;
        }

        const masterPassword =
            sessionStorage.getItem(
                "masterPassword"
            );

        if(!masterPassword){

            alert(
                "Session habis"
            );

            return;
        }

        for(const item of data.vaults){

            try{

                const decrypted =

                await decryptData(

                    masterPassword,
                    item.encrypted_data,
                    item.iv,
                    item.salt

                );

                vaultContainer.innerHTML += `

                <div class="table-row">

                    <span>
                        ${item.website}
                    </span>

                    <span>
                        ${item.username}
                    </span>

                    <span>
                        ••••••••
                    </span>

                    <span class="actions">

                    <!-- VIEW -->
                    <button
                    class="view-btn"

                    onclick='viewPassword(
                    ${JSON.stringify(item.encrypted_data)},
                    ${JSON.stringify(item.iv)},
                    ${JSON.stringify(item.salt)}
                    )'
                    >

                    <i class="bi bi-eye-fill"></i>

                    </button>


                    <!-- COPY -->
                    <button
                    class="copy-btn"

                    onclick='copyPassword(
                    ${JSON.stringify(item.encrypted_data)},
                    ${JSON.stringify(item.iv)},
                    ${JSON.stringify(item.salt)}
                    )'
                    >

                    <i class="bi bi-clipboard-fill"></i>

                    </button>


                    <!-- EDIT -->
                    <button
                    class="edit-btn"

                    onclick='editVaultData(
                    ${item.id},
                    ${JSON.stringify(item.encrypted_data)},
                    ${JSON.stringify(item.iv)},
                    ${JSON.stringify(item.salt)}
                    )'
                    >

                    <i class="bi bi-pencil-square"></i>

                    </button>


                    <!-- DELETE -->
                    <button
                    class="delete-btn"

                    onclick='deleteVault(
                    ${item.id}
                    )'
                    >

                    <i class="bi bi-trash-fill"></i>

                    </button>

                    </span>

                </div>

                `;

            }

            catch(err){

                console.log(
                    "Decrypt gagal:",
                    err
                );

            vaultContainer.innerHTML += `

                <div class="table-row">

                <span>
                    ${item.website}
                </span>

                <span>
                    ${item.username}
                </span>

                    <span style="
                        color:red;
                        font-weight:bold;
                    ">
                        ❌ Data rusak / gagal decrypt
                    </span>

                    <span class="actions">

                        <button
                        class="view-btn"
                        disabled>

                        <i class="bi bi-eye-fill"></i>

                        </button>

                        <button
                        class="copy-btn"
                        disabled>

                        <i class="bi bi-clipboard-fill"></i>

                        </button>

                        <button
                        class="edit-btn"
                        disabled>

                        <i class="bi bi-pencil-square"></i>

                        </button>

                        <button
                        class="delete-btn"

                        onclick='deleteVault(
                        ${item.id}
                        )'
                        >

                        <i class="bi bi-trash-fill"></i>

                        </button>

                    </span>

                </div>

                `;
            }

        }

    }

    catch(err){

        console.log(err);

        alert(
            "Gagal load vault"
        );

    }

}


/* =========================
VIEW PASSWORD
========================= */

async function viewPassword(

    encryptedData,
    iv,
    salt

){

    const masterPassword=

    prompt(
    "Masukkan Master Password"
    );

    if(!masterPassword){

        return;
    }

    try{

        const decrypted=

        await decryptData(

            masterPassword,
            encryptedData,
            iv,
            salt

        );

        alert(

            "Password : " +

            decrypted.password
        );

    }

    catch{

        alert(

        "❌ Wrong Master Password"

        );
    }
}


/* =========================
COPY PASSWORD
========================= */

async function copyPassword(

encryptedData,
iv,
salt

){

const masterPassword=

prompt(
"Masukkan Master Password"
);

if(!masterPassword){

return;
}

try{

const decrypted=

await decryptData(

masterPassword,
encryptedData,
iv,
salt

);

navigator.clipboard.writeText(

decrypted.password

);

alert(
"Password dicopy"
);

}

catch{

alert(

"❌ Wrong Master Password"

);

}

}


/* =========================
EDIT VAULT
========================= */

async function editVaultData(

id,
encryptedData,
iv,
salt

){

const masterPassword=

prompt(

"Masukkan Master Password"

);

if(!masterPassword){

return;
}

try{

const decrypted=

await decryptData(

masterPassword,
encryptedData,
iv,
salt

);

editVault(

id,
decrypted.website,
decrypted.username,
decrypted.password,
decrypted.notes

);

}

catch(err){

console.log(err);

alert(

"❌ Data rusak / gagal decrypt"

);

}

}


function editVault(

id,
website,
username,
password,
notes

){

editId=id;

document.getElementById(
'website'
).value=website;

document.getElementById(
'username'
).value=username;

document.getElementById(
'password'
).value=password;

document.getElementById(
'notes'
).value=notes;

}


/* =========================
DELETE
========================= */

async function deleteVault(id){

if(
!confirm(
"Yakin hapus?"
)
){

return;
}

try{

const response=

await fetch(

"../api/delete_vault.php",

{

method:"POST",

headers:{

"Content-Type":

"application/json"

},

body:JSON.stringify({

id:id

})

}

);

const data=

await response.json();

alert(
data.message
);

if(data.success){

loadVault();

}

}catch{

alert(
"Gagal hapus"
);

}

}


/* =========================
CLEAR
========================= */

function clearForm(){

editId=null;

document.getElementById(
'website'
).value="";

document.getElementById(
'username'
).value="";

document.getElementById(
'password'
).value="";

document.getElementById(
'notes'
).value="";
}

/* =========================
PASSWORD STRENGTH
========================= */

function checkStrength(password){

    const strengthText =
    document.getElementById(
        "strengthText"
    );

    const strengthFill =
    document.getElementById(
        "strengthFill"
    );

    if(
        !strengthText ||
        !strengthFill
    ){
        return;
    }

    let score = 0;

        const hasLength =
        password.length >= 8;

        const hasLower =
        /[a-z]/.test(password);

        const hasUpper =
        /[A-Z]/.test(password);

        const hasNumber =
        /[0-9]/.test(password);

        const hasSymbol =
        /[^A-Za-z0-9]/.test(password);


        if(hasLength)
            score++;

        if(hasLower)
            score++;

        if(hasUpper)
            score++;

        if(hasNumber)
            score++;

        if(hasSymbol)
            score++;

    let text="-";
    let width="0%";
    let color="#d1d5db";

    switch(score){

    case 1:
    case 2:
        text="Weak";
        width="25%";
        color="#ef4444";
        break;

    case 3:
    case 4:
        text="Medium";
        width="50%";
        color="#f59e0b";
        break;

    case 5:
        text="Strong";
        width="100%";
        color="#22c55e";
        break;
}

    if(password===""){

        text="-";
        width="0%";
        color="#d1d5db";
    }

    strengthText.innerText =
    "Strength : " + text;

    strengthFill.style.width =
    width;

    strengthFill.style.background =
    color;
}

/* =========================
AUTO LOAD
========================= */

document.addEventListener(

"DOMContentLoaded",

()=>{

loadVault();

}

);