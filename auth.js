import { initializeApp } from 'https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js';
import { getAuth, signInWithEmailAndPassword, createUserWithEmailAndPassword, signInWithPopup, GoogleAuthProvider, signOut } from 'https://www.gstatic.com/firebasejs/9.0.0/firebase-auth.js';

// Configurazione Firebase
const firebaseConfig = {
  apiKey: "AIzaSyAjE3G5rxR87hvpTrz1PI9k7jXz6-Hv7Ro",
  authDomain: "real-world-tycoon.firebaseapp.com",
  projectId: "real-world-tycoon",
  storageBucket: "real-world-tycoon.appspot.com",
  messagingSenderId: "682062515277",
  appId: "1:682062515277:web:7bbfc1f7f25640e9dee004",
  measurementId: "G-KPF98KCMJD"
};

// Inizializza Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

// Gestione Registrazione
document.getElementById('register-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('register-email').value;
    const password = document.getElementById('register-password').value;

    createUserWithEmailAndPassword(auth, email, password)
        .then((userCredential) => {
            const user = userCredential.user;
            console.log("User registered: ", user);
            alert('Registration successful!');
            saveUserToDatabase(user.uid, user.email, ''); // Salva l'utente nel database
            window.location.href = "dashboard.php";
        })
        .catch((error) => {
            console.error("Error during registration: ", error);
            alert('Registration failed: ' + error.message);
        });
});

// Gestione Login
document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;

    signInWithEmailAndPassword(auth, email, password)
        .then((userCredential) => {
            const user = userCredential.user;
            console.log("User signed in: ", user);
            window.location.href = "dashboard.php";
        })
        .catch((error) => {
            console.error("Error during sign-in: ", error);
            alert('Login failed: ' + error.message);
        });
});

// Gestione Login con Google
document.getElementById('google-signin-button').addEventListener('click', function() {
    const provider = new GoogleAuthProvider();
    signInWithPopup(auth, provider)
        .then((result) => {
            const user = result.user;
            console.log("User signed in with Google: ", user);
            saveUserToDatabase(user.uid, user.email, user.displayName);
            window.location.href = "dashboard.php";
        })
        .catch((error) => {
            console.error("Error during Google sign-in: ", error);
            alert('Google sign-in failed: ' + error.message);
        });
});

// Gestione Logout
function signOutUser() {
    signOut(auth).then(() => {
        console.log("User signed out");
        window.location.href = "index.php";
    }).catch((error) => {
        console.error("Error during sign-out: ", error);
        alert("Sign out failed: " + error.message);
    });
}

// Salvataggio dell'utente nel database PHP
function saveUserToDatabase(uid, email, name) {
    fetch('backend.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            uid: uid,
            email: email,
            name: name
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

// Controllo dello stato di autenticazione
auth.onAuthStateChanged((user) => {
    if (user) {
        console.log("User is signed in: ", user);
    } else {
        console.log("No user is signed in.");
    }
});

window.signOutUser = signOutUser;
