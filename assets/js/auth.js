async function register() {

  const name =
    document.getElementById('name').value;

  const email =
    document.getElementById('email').value;

  const password =
    document.getElementById('password').value;

  try {

    /* GENERATE SALT */
    const saltArray =
      crypto.getRandomValues(
        new Uint8Array(16)
      );

    const salt = btoa(
      String.fromCharCode(...saltArray)
    );

    /* DERIVE AUTH VERIFIER */
    const authVerifier =
      await deriveAuthVerifier(
        password,
        salt
      );

    const response = await fetch(
      '../api/register.php',
      {
        method: 'POST',

        headers: {
          'Content-Type': 'application/json'
        },

        body: JSON.stringify({
          name,
          email,
          authVerifier,
          salt
        })
      }
    );

    const data = await response.json();

    alert(data.message);

    if(data.success){
      window.location = 'login.php';
    }

  } catch(err){

    console.error(err);

    alert(
      "Server error / API tidak ditemukan"
    );
  }
}

async function login() {

  const email =
    document.getElementById('email').value;

  const password =
    document.getElementById('password').value;

  try {

    /* AMBIL SALT USER */
    const saltResponse =
      await fetch(
        `../api/get_salt.php?email=${encodeURIComponent(email)}`
      );

    const saltData =
      await saltResponse.json();

    if(!saltData.success){

      alert("User tidak ditemukan");

      return;
    }

    /* DERIVE AUTH VERIFIER */
    const authVerifier =
      await deriveAuthVerifier(
        password,
        saltData.salt
      );

    /* LOGIN */
    const response =
      await fetch(
        '../api/login.php',
        {

          method: 'POST',

          credentials: 'include',

          headers: {
            'Content-Type':
              'application/json'
          },

          body: JSON.stringify({
            email,
            authVerifier
          })
        }
      );

    const data =
      await response.json();

    if (data.success) {

      sessionStorage.setItem(
        'masterPassword',
        password
      );

      sessionStorage.setItem(
        'email',
        email
      );

      alert('Login berhasil');

      window.location =
        'dashboard.php';

    } else {

      alert(data.message);
    }

  } catch(err){

    console.error(err);

    alert("Server error");
  }
}