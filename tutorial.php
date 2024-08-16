<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real World Tycoon - Tutorial</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="tutorial_styles.css">
</head>
<body>
    <!-- Schermata di Caricamento -->
    <div id="loadingSection" class="section visible">
        <img src="logo.png" alt="Logo" class="logo">
        <div class="progress mt-4">
            <div class="progress-bar progress-bar-striped progress-bar-animated" id="progressBar"></div>
        </div>
        <button id="startTutorialButton" class="btn btn-primary mt-4" style="display: none;">Inizia</button>
    </div>

    <!-- Schermata di Benvenuto -->
    <div id="welcomeSection" class="section">
        <div class="welcome-text">
            <p id="typingText"></p>
        </div>
        <button id="startButton" class="btn btn-primary mt-4" style="display: none;">SONO PRONTO</button>
    </div>

    <!-- Pagina Tutorial - Selezione della Categoria -->
    <div id="categorySection" class="section">
        <div class="tutorial-content">
            <h3>E' giunto il momento che tu scelga in che ambito iniziare il tuo business:</h3>
            <form id="categoryForm">
                <div class="form-group mt-4">
                    <label><input type="radio" name="category" value="TRANSPORTS" required> <img src="img/transports.png" class="img-thumbnail" alt="Trasporti"></label>
                    <label><input type="radio" name="category" value="ENERGY"> <img src="img/energy.png" class="img-thumbnail" alt="Energia"></label>
                    <label><input type="radio" name="category" value="RAW_MATERIALS"> <img src="img/raw_materials.png" class="img-thumbnail" alt="Materie Prime"></label>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Avanti</button>
            </form>
        </div>
    </div>

    <!-- Pagina Tutorial - Inserimento del Nome dell'Azienda -->
    <div id="businessNameSection" class="section">
        <div class="tutorial-content">
            <h3>Benissimo, ottima scelta! Ora inserisci il nome del tuo nuovo business:</h3>
            <form id="businessNameForm">
                <div class="form-group mt-4">
                    <input type="text" id="businessName" class="form-control" placeholder="Nome Azienda" required>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Avanti</button>
            </form>
        </div>
    </div>

    <!-- Pagina Tutorial - Selezione della Posizione -->
    <div id="locationSection" class="section">
        <div class="tutorial-content">
            <h3>Dove vuoi far nascere il tuo business?</h3>
            <div id="map"></div>
            <button id="confirmLocationButton" class="btn btn-primary mt-4" style="display: none;">Conferma Posizione</button>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="tutorial_scripts.js"></script>
</body>
</html>
