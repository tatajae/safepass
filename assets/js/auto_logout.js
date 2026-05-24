const timeout =
    localStorage.getItem('sessionTimeout');

if(timeout === "true"){

    setTimeout(() => {
        alert("Session habis");
        window.location = "../login.php";
    }, 5 * 60 * 1000);

}