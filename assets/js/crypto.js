async function deriveKey(password, salt) {

  const enc = new TextEncoder();

  const keyMaterial =
    await crypto.subtle.importKey(
      "raw",
      enc.encode(password),
      "PBKDF2",
      false,
      ["deriveKey"]
    );

  return crypto.subtle.deriveKey(
    {
      name: "PBKDF2",
      salt,
      iterations: 600000,
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

async function encryptData(text, password) {

  const enc = new TextEncoder();

  const iv =
    crypto.getRandomValues(
      new Uint8Array(12)
    );

  const salt =
    crypto.getRandomValues(
      new Uint8Array(16)
    );

  const key =
    await deriveKey(
      password,
      salt
    );

  const encrypted =
    await crypto.subtle.encrypt(
      {
        name: "AES-GCM",
        iv
      },
      key,
      enc.encode(text)
    );

  return {

    ciphertext: btoa(
      String.fromCharCode(
        ...new Uint8Array(encrypted)
      )
    ),

    iv: btoa(
      String.fromCharCode(...iv)
    ),

    salt: btoa(
      String.fromCharCode(...salt)
    )
  };
}

async function decryptData(
  ciphertext,
  iv,
  salt,
  password
) {

  const dec = new TextDecoder();

  const encryptedBytes =
    Uint8Array.from(
      atob(ciphertext),
      c => c.charCodeAt(0)
    );

  const ivBytes =
    Uint8Array.from(
      atob(iv),
      c => c.charCodeAt(0)
    );

  const saltBytes =
    Uint8Array.from(
      atob(salt),
      c => c.charCodeAt(0)
    );

  const key =
    await deriveKey(
      password,
      saltBytes
    );

  const decrypted =
    await crypto.subtle.decrypt(
      {
        name: "AES-GCM",
        iv: ivBytes
      },
      key,
      encryptedBytes
    );

  return dec.decode(decrypted);
}