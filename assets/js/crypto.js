// ===== PBKDF2 KEY DERIVATION =====
async function deriveKey(password, salt) {
    const enc = new TextEncoder();

    const keyMaterial = await crypto.subtle.importKey(
        "raw",
        enc.encode(password),
        "PBKDF2",
        false,
        ["deriveKey"]
    );

    return crypto.subtle.deriveKey(
        {
            name: "PBKDF2",
            salt: enc.encode(salt),
            iterations: 210000,
            hash: "SHA-256"
        },
        keyMaterial,
        {
            name: "AES-GCM",
            length: 256
        },
        false,
        ["encrypt", "decrypt"]
    );
}
async function encryptData(key, data) {
    const iv = crypto.getRandomValues(new Uint8Array(12));
    const enc = new TextEncoder();

    const encrypted = await crypto.subtle.encrypt(
        {
            name: "AES-GCM",
            iv: iv
        },
        key,
        enc.encode(data)
    );

    return {
        iv: btoa(String.fromCharCode(...iv)),
        data: btoa(String.fromCharCode(...new Uint8Array(encrypted)))
    };
}
async function decryptData(key, iv, data) {
    const dec = new TextDecoder();

    const ivArray = Uint8Array.from(atob(iv), c => c.charCodeAt(0));
    const dataArray = Uint8Array.from(atob(data), c => c.charCodeAt(0));

    const decrypted = await crypto.subtle.decrypt(
        {
            name: "AES-GCM",
            iv: ivArray
        },
        key,
        dataArray
    );

    return dec.decode(decrypted);
}
