
let mode = "add";
let editId = null;

/* =========================
   DARK MODE
========================= */
window.toggleDarkMode = function(){

    document.body.classList.toggle('dark-mode');

    localStorage.setItem(
        "theme",
        document.body.classList.contains('dark-mode')
            ? "dark"
            : "light"
    );
};

/* =========================
   LOAD THEME
========================= */
window.onload = function(){

    if(localStorage.getItem("theme") === "dark"){
        document.body.classList.add("dark-mode");
    }
};

/* =========================
   SAVE VAULT (ADD / EDIT)
========================= */
async function saveVault(){

    const website = document.getElementById('website').value;
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if(!website || !username || !password){
        alert("Semua field wajib diisi");
        return;
    }

    let url = "";
    let payload = {};

    if(mode === "add"){

        url = "../api/tambah_vault.php";

        payload = {
            website,
            username,
            password
        };

    } else {

        url = "../api/edit_vault.php";

        payload = {
            id: editId,
            website,
            username,
            password
        };
    }

    try {

        const res = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        });

        const data = await res.json();

        alert(data.message);

        if(data.success){
            clearForm();
            location.reload();
        }

    } catch(err){
        console.error(err);
        alert("Terjadi error saat menyimpan");
    }
}

/* =========================
   EDIT VAULT
========================= */
function editVault(id, website, username){

    mode = "edit";
    editId = id;

    document.getElementById('website').value = website;
    document.getElementById('username').value = username;
    document.getElementById('password').value = "";

    document.getElementById('formTitle').innerText = "Edit Password";
}
/* =========================
   DELETE VAULT
========================= */
async function deleteVault(id){

    if(!confirm("Yakin ingin menghapus data ini?")){
        return;
    }

    try {

        const res = await fetch("../api/delete_vault.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                id: id
            })
        });

        const data = await res.json();

        alert(data.message);

        if(data.success){
            location.reload();
        }

    } catch(err){
        console.error(err);
        alert("Gagal menghapus data");
    }
}
/* =========================
   CLEAR FORM
========================= */
function clearForm(){

    document.getElementById('website').value = "";
    document.getElementById('username').value = "";
    document.getElementById('password').value = "";

    document.getElementById('formTitle').innerText = "Tambah Password";

    mode = "add";
    editId = null;
}

/* =========================
   SEARCH VAULT
========================= */
function searchVault(){

    const input = document.getElementById('search').value.toLowerCase();
    const rows = document.querySelectorAll('.table-row');

    rows.forEach(row => {
        row.style.display =
            row.innerText.toLowerCase().includes(input)
                ? "grid"
                : "none";
    });
}

/* =========================
   PASSWORD STRENGTH
========================= */
function checkStrength(password){

    const text = document.getElementById('strengthText');
    const bar = document.getElementById('strengthFill');

    let score = 0;

    if(password.length >= 8) score++;
    if(/[A-Z]/.test(password)) score++;
    if(/[a-z]/.test(password)) score++;
    if(/[0-9]/.test(password)) score++;
    if(/[\W]/.test(password)) score++;

    if(score <= 2){
        text.innerText = "Strength: Weak";
        text.style.color = "#ef4444";
        bar.style.width = "33%";
        bar.style.background = "#ef4444";
    }
    else if(score <= 4){
        text.innerText = "Strength: Medium";
        text.style.color = "#f59e0b";
        bar.style.width = "66%";
        bar.style.background = "#f59e0b";
    }
    else{
        text.innerText = "Strength: Strong";
        text.style.color = "#22c55e";
        bar.style.width = "100%";
        bar.style.background = "#22c55e";
    }
}

/* =========================
   VIEW PASSWORD
========================= */
function viewPassword(password){
    alert("Password: " + password);
}

/* =========================
   COPY PASSWORD
========================= */
function copyPassword(password){

    navigator.clipboard.writeText(password);
    alert("Password berhasil dicopy");
}

/* =========================
   SETTINGS
========================= */
async function saveSettings(){

    const old_password = document.getElementById('old_password').value;
    const new_password = document.getElementById('new_password').value;
    const confirm_password = document.getElementById('confirm_password').value;

    if(new_password !== confirm_password){
        alert("Password tidak cocok");
        return;
    }

    try {

        const res = await fetch('../api/update_security.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                old_password,
                new_password
            })
        });

        const data = await res.json();
        alert(data.message);

    } catch(err){
        console.error(err);
        alert("Terjadi error saat menyimpan");
    }
}

function resetSettings(){
    location.reload();
}