const encoder = new TextEncoder();
const decoder = new TextDecoder();

function arrayBufferToBase64(buffer) {
    return btoa(String.fromCharCode(...new Uint8Array(buffer)));
}

function base64ToArrayBuffer(base64) {
    return Uint8Array.from(atob(base64), c => c.charCodeAt(0));
}

// Generate random salt
function generateSalt() {
    return crypto.getRandomValues(new Uint8Array(16));
}

// Generate IV AES-GCM
function generateIV() {
    return crypto.getRandomValues(new Uint8Array(12));
}

// Derive AES Key dari master password
async function deriveKey(masterPassword, salt) {
    const keyMaterial = await crypto.subtle.importKey(
        "raw",
        encoder.encode(masterPassword),
        { name: "PBKDF2" },
        false,
        ["deriveKey"]
    );

    return crypto.subtle.deriveKey(
        {
            name: "PBKDF2",
            salt: salt,
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

// Encrypt data
async function encryptData(masterPassword, data, saltBase64 = null) {
    let salt;

    if (saltBase64) {
        salt = base64ToArrayBuffer(saltBase64);
    } else {
        salt = generateSalt();
    }

    const key = await deriveKey(masterPassword, salt);

    const iv = generateIV();

    const encrypted = await crypto.subtle.encrypt(
        {
            name: "AES-GCM",
            iv: iv
        },
        key,
        encoder.encode(JSON.stringify(data))
    );

    return {
        encrypted_data: arrayBufferToBase64(encrypted),
        iv: arrayBufferToBase64(iv),
        salt: arrayBufferToBase64(salt)
    };
}

// Decrypt data
async function decryptData(masterPassword, encryptedData, ivBase64, saltBase64) {
    const salt = base64ToArrayBuffer(saltBase64);
    const iv = base64ToArrayBuffer(ivBase64);

    const key = await deriveKey(masterPassword, salt);

    const decrypted = await crypto.subtle.decrypt(
        {
            name: "AES-GCM",
            iv: iv
        },
        key,
        base64ToArrayBuffer(encryptedData)
    );

    return JSON.parse(decoder.decode(decrypted));
}
