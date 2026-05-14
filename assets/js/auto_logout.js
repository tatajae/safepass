let logoutTimer;

function resetTimer(){

  clearTimeout(logoutTimer);

  logoutTimer = setTimeout(() => {

    alert('Session expired');

    window.location = '../api/logout.php';

  }, 300000);
}


window.onload = resetTimer;

document.onmousemove = resetTimer;
document.onkeypress = resetTimer;
document.onclick = resetTimer;