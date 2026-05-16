
let mode = "add";
let editId = null;
/*===================/
   VAULT ENCRYPTION
/===================*/

async function savePassword(){

    const website =
      document.getElementById('website').value;

    const username =
      document.getElementById('username').value;

    const password =
      document.getElementById('password').value;

    const notes =
      document.getElementById('notes').value;

/* VALIDASI */ 
    if( !website || !username || !password ){ 
      alert( "Website, Username, dan Password wajib diisi" ); 
      return; 
    }

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

    const encrypted =
      await encryptData(
        masterPassword,
        vaultData
      );

    const response =
      await fetch(
        '../api/save_vault.php',
        {
            method:'POST',

            headers:{
                'Content-Type':
                  'application/json'
            },

            body: JSON.stringify({
                encrypted_data:
                  encrypted.encrypted_data,

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

    if(data.success){
        loadVault();
    }
}

async function loadVault(){

    try{

        const response =
          await fetch(
            '../api/get_vault.php'
          );

        const data =
          await response.json();

        if(!data.success){

            alert("Gagal load vault");

            return;
        }

        const masterPassword =
          sessionStorage.getItem(
            'masterPassword'
          );

        const vaultContainer =
          document.getElementById(
            'vaultContainer'
          );

        vaultContainer.innerHTML = '';

        for(const item of data.vaults){

            const decrypted =
              await decryptData(
                masterPassword,
                item.encrypted_data,
                item.iv,
                item.salt
              );

            vaultContainer.innerHTML += `
                <div class="vault-card">

                    <h3>
                      ${decrypted.website}
                    </h3>

                    <p>
                      Username:
                      ${decrypted.username}
                    </p>

                    <p>
                      Password:
                      ${decrypted.password}
                    </p>

                    <p>
                      Notes:
                      ${decrypted.notes}
                    </p>

                </div>
            `;
        }

    } catch(err){

        console.error(err);

        alert("Gagal decrypt vault");
    }
}
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

    /* LOAD THEME */
    if(localStorage.getItem("theme") === "dark"){
        document.body.classList.add("dark-mode");
    }

    /* LOAD VAULT */
    loadVault();
};
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