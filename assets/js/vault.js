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

    const notes =
        document.getElementById('notes').value.trim();

    /* VALIDASI */
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
            sessionStorage.getItem('masterPassword');

        if (!masterPassword) {

            alert("Session master password hilang");

            window.location = "login.php";

            return;
        }

        /* ENCRYPT */
        const encrypted =
            await encryptData(
                masterPassword,
                vaultData
            );

        let apiUrl = "../api/save_vault.php";

        /* MODE EDIT */
        if (editId !== null) {
          apiUrl = "../api/edit_vault.php";
        }

        const response = await fetch(apiUrl, {

            method: "POST",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify({

                id: editId,

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

        if (data.success) {

          editId = null;
          clearForm();
          loadVault();
        }

    } catch (err) {

        console.error(err);

        alert("Gagal menyimpan vault");
    }
}

/* =========================
   LOAD VAULT
========================= */
/* =========================
   LOAD VAULT
========================= */
async function loadVault() {

    try {

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

        vaultContainer.innerHTML = "";

        if (!data.success) {

            vaultContainer.innerHTML = `
                <div class="table-row">
                    <span>Gagal load data</span>
                </div>
            `;

            return;
        }

        const masterPassword =
            sessionStorage.getItem(
                "masterPassword"
            );

        if(!masterPassword){

            alert("Session habis, login ulang");

            window.location = "login.php";

            return;
        }

        /* LOOP DATA */
        for (const item of data.vaults) {

            try {

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
                            ${decrypted.website}
                        </span>

                        <span>
                            ${decrypted.username}
                        </span>

                        <span>
                            ••••••••
                        </span>

                        <span class="actions">

                            <!-- VIEW -->
                            <button
                                class="view-btn"
                                onclick='viewPassword(
                                    ${JSON.stringify(decrypted.password)}
                                )'
                            >
                                <i class="bi bi-eye-fill"></i>
                            </button>

                            <!-- COPY -->
                            <button
                                class="copy-btn"
                                onclick='copyPassword(
                                    ${JSON.stringify(decrypted.password)}
                                )'
                            >
                                <i class="bi bi-clipboard-fill"></i>
                            </button>

                            <!-- EDIT -->
                            <button
                                class="edit-btn"
                                onclick='editVault(
                                    ${item.id},
                                    ${JSON.stringify(decrypted.website)},
                                    ${JSON.stringify(decrypted.username)},
                                    ${JSON.stringify(decrypted.password)},
                                    ${JSON.stringify(decrypted.notes || "")}
                                )'
                            >
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <!-- DELETE -->
                            <button
                                class="delete-btn"
                                onclick="deleteVault(${item.id})"
                            >
                                <i class="bi bi-trash-fill"></i>
                            </button>

                        </span>

                    </div>
                `;

            } catch(err){

                console.error("Decrypt gagal", err);
            }
        }

        /* KOSONG */
        if (data.vaults.length === 0) {

            vaultContainer.innerHTML = `
                <div class="table-row">
                    <span>Tidak ada data</span>
                    <span>-</span>
                    <span>-</span>
                    <span>-</span>
                </div>
            `;
        }

    } catch (err) {

        console.error(err);

        alert("Gagal load vault");
    }
}

/* =========================
   VIEW PASSWORD
========================= */
function viewPassword(password) {

    alert("Password : " + password);
}

/* =========================
   COPY PASSWORD
========================= */
function copyPassword(password) {

    navigator.clipboard.writeText(password);

    alert("Password berhasil dicopy");
}

/* =========================
   EDIT VAULT
========================= */
function editVault(
    id,
    website,
    username,
    password,
    notes
) {

    editId = id;

    document.getElementById(
        'website'
    ).value = website;

    document.getElementById(
        'username'
    ).value = username;

    document.getElementById(
        'password'
    ).value = password;

    document.getElementById(
        'notes'
    ).value = notes;

    document.getElementById(
        'formTitle'
    ).innerHTML = `
        <i class="bi bi-pencil-square"></i>
        Edit Password
    `;
}

/* =========================
   DELETE VAULT
========================= */
async function deleteVault(id) {

    if (!confirm("Yakin ingin menghapus?")) {
        return;
    }

    try {

        const response = await fetch(
            "../api/delete_vault.php",
            {
                method: "POST",

                headers: {
                    "Content-Type": "application/json"
                },

                body: JSON.stringify({
                    id: id
                })
            }
        );

        const data = await response.json();

        alert(data.message);

        if (data.success) {

            loadVault();
        }

    } catch (err) {

        console.error(err);

        alert("Gagal menghapus");
    }
}

/* =========================
   CLEAR FORM
========================= */
function clearForm() {

    editId = null;

    document.getElementById(
        'website'
    ).value = "";

    document.getElementById(
        'username'
    ).value = "";

    document.getElementById(
        'password'
    ).value = "";

    document.getElementById(
        'notes'
    ).value = "";

    document.getElementById(
        'formTitle'
    ).innerHTML = `
        <i class="bi bi-plus-circle-fill"></i>
        Tambah Password
    `;
}

/* =========================
   PASSWORD STRENGTH
========================= */
function checkStrength(password) {

    const text =
        document.getElementById(
            'strengthText'
        );

    const bar =
        document.getElementById(
            'strengthFill'
        );

    let score = 0;

    if (password.length >= 8) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[a-z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[\W]/.test(password)) score++;

    if (score <= 2) {

        text.innerText =
            "Strength : Weak";

        bar.style.width = "33%";
        bar.style.background = "red";

    }
    else if (score <= 4) {

        text.innerText =
            "Strength : Medium";

        bar.style.width = "66%";
        bar.style.background = "orange";

    }
    else {

        text.innerText =
            "Strength : Strong";

        bar.style.width = "100%";
        bar.style.background = "green";
    }
}

/* =========================
   AUTO LOAD
========================= */
document.addEventListener(
    "DOMContentLoaded",
    function () {

        const vaultContainer =
            document.getElementById(
                "vaultContainer"
            );

        /* LOAD DATA VAULT */
        if (vaultContainer) {

            loadVault();
        }
    }
);