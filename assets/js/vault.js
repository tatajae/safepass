const form = document.getElementById('vaultForm');

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const service = document.getElementById('service').value;
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const notes = document.getElementById('notes').value;

    const masterPassword = sessionStorage.getItem('masterPassword');
    const salt = localStorage.getItem('salt');

    const vaultData = {
        username,
        password,
        notes
    };

    const encrypted = await encryptData(
        masterPassword,
        vaultData,
        salt
    );

    const response = await fetch('API/save_vault.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            service,
            encrypted_data: encrypted.encrypted_data,
            iv: encrypted.iv
        })
    });

    const result = await response.json();

    if(result.success) {
        alert('Vault berhasil disimpan');
    }
});
async function loadVaults() {

    const response = await fetch('API/get_vaults.php');
    const vaults = await response.json();

    const masterPassword = sessionStorage.getItem('masterPassword');
    const salt = localStorage.getItem('salt');

    for (const vault of vaults) {

        const decrypted = await decryptData(
            masterPassword,
            vault.encrypted_data,
            vault.iv,
            salt
        );

        console.log(decrypted);
    }
}
