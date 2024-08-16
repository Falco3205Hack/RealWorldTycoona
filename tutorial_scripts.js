// Simula il caricamento con la progress bar
const loadingSection = document.getElementById('loadingSection');
const welcomeSection = document.getElementById('welcomeSection');
const progressBar = document.getElementById('progressBar');
const startTutorialButton = document.getElementById('startTutorialButton');

let progress = 0;
const loadingInterval = setInterval(() => {
    progress += 10;
    progressBar.style.width = progress + '%';

    if (progress >= 100) {
        clearInterval(loadingInterval);
        startTutorialButton.style.display = 'inline-block';
    }
}, 500);

// Inizia il tutorial quando l'utente clicca su "Inizia"
startTutorialButton.addEventListener('click', () => {
    showSection('welcomeSection');
    startTypingEffect();
});

// Macchina da scrivere e voce narrante (Text-to-Speech)
const text = "Benvenuto su Real World Tycoon,\nin questa nuova avventura prenderai i panni di un manager aziendale scegliendo il nome della tua azienda, la categoria e la posizione della tua azienda e molto altro!\nNon perdere altro tempo! Ricordati il tempo è denaro e attualmente non ne hai tantissimo nelle tue tasche!\nSei pronto ad iniziare?";
const typingTextElement = document.getElementById('typingText');
const startButton = document.getElementById('startButton');
let index = 0;

function startTypingEffect() {
    speakText(text);
    typeText();
}

function typeText() {
    if (index < text.length) {
        typingTextElement.innerHTML += text.charAt(index).replace(/\n/g, "<br>");
        index++;
        setTimeout(typeText, 50);
    } else {
        startButton.style.display = 'inline-block';
    }
}

startButton.addEventListener('click', () => {
    showSection('categorySection');
    speakText("E' giunto il momento che tu scelga in che ambito iniziare il tuo business.");
});

// Funzione per mostrare le sezioni
function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(section => {
        section.classList.remove('visible');
    });
    document.getElementById(sectionId).classList.add('visible');
}

// Funzione Text-to-Speech
function speakText(text) {
    const msg = new SpeechSynthesisUtterance();
    msg.text = text;
    msg.lang = 'it-IT';  // Imposta la lingua italiana
    window.speechSynthesis.speak(msg);
}

// Gestione della selezione della categoria
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const selectedCategory = document.querySelector('input[name="category"]:checked').value;

    // Simula il salvataggio della categoria e passa alla prossima sezione
    setTimeout(() => {
        showSection('businessNameSection');
        speakText("Benissimo, ottima scelta! Ora inserisci il nome del tuo nuovo business.");
    }, 500);
});

// Gestione dell'inserimento del nome dell'azienda
document.getElementById('businessNameForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const businessName = document.getElementById('businessName').value;

    // Simula il salvataggio del nome dell'azienda e passa alla prossima sezione
    setTimeout(() => {
        showSection('locationSection');
        initMap();
        speakText("Dove vuoi far nascere il tuo business?");
    }, 500);
});

// Inizializza la mappa con Leaflet
function initMap() {
    const map = L.map('map').setView([41.8719, 12.5674], 5); // Centro sull'Italia

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    const locations = [
        { lat: 45.4642, lng: 9.19, name: 'Milano' },
        { lat: 41.9028, lng: 12.4964, name: 'Roma' },
        { lat: 40.8518, lng: 14.2681, name: 'Napoli' },
        { lat: 43.7696, lng: 11.2558, name: 'Firenze' },
        { lat: 44.4949, lng: 11.3426, name: 'Bologna' },
        // Aggiungi altre città qui
    ];

    let selectedCity = null;

    locations.forEach(location => {
        const marker = L.marker([location.lat, location.lng]).addTo(map)
            .bindPopup(location.name)
            .on('click', function() {
                selectedCity = location.name;
                document.getElementById('confirmLocationButton').style.display = 'inline-block';
            });
    });

    document.getElementById('confirmLocationButton').addEventListener('click', function() {
        if (selectedCity) {
            saveUserData(selectedCity); // Salva i dati nel tuo database
            setTimeout(() => {
                window.location.href = 'dashboard.php';
            }, 500);
        }
    });
}

// Funzione per salvare i dati dell'utente nel database
function saveUserData(city) {
    const businessName = document.getElementById('businessName').value;
    const category = document.querySelector('input[name="category"]:checked').value;

    // Esegui la chiamata AJAX per salvare i dati
    fetch('save_tutorial_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            businessName: businessName,
            category: category,
            city: city
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
