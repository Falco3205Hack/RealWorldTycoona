function signOutUser() {
    fetch('logout.php', {
        method: 'POST',
        credentials: 'same-origin'
    })
    .then(response => {
        if (response.ok) {
            window.location.href = 'index.php';
        } else {
            alert("Logout fallito!");
        }
    })
    .catch(error => console.error('Errore:', error));
}
