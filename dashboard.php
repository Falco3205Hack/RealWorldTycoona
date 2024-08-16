<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Include il file per verificare se l'utente ha completato il tutorial
require 'check_tutorial_completion.php';
if (!$tutorial_completed) {
    header('Location: tutorial.php');
    exit();
}

// Connessione al database
require 'db_connection.php';

// Ottieni i dati dell'azienda collegata all'utente
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM companies WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$company = $result->fetch_assoc();

$category = $company['category'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real World Tycoon - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Barra superiore -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Real World Tycoon</span>
            <div class="d-flex">
                <span class="navbar-text me-3">
                    💰 <?php echo number_format($company['funds'], 2); ?> EUR
                </span>
                <button onclick="signOutUser()" class="btn btn-danger ms-3">Logout</button>
            </div>
        </div>
    </nav>

    <!-- Contenitore principale per le app -->
    <div class="container-fluid main-container">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <!-- Dashboard Generale -->
                <div class="swiper-slide">
                    <div class="app-grid">
                        <div class="app-icon">
                            <img src="img/transport.png" alt="Trasporti">
                            <p>Gestione Trasporti</p>
                        </div>
                        <div class="app-icon">
                            <img src="img/energy.png" alt="Energia">
                            <p>Gestione Energia</p>
                        </div>
                        <div class="app-icon">
                            <img src="img/raw_materials.png" alt="Materie Prime">
                            <p>Gestione Materie Prime</p>
                        </div>
                        <div class="app-icon">
                            <img src="img/shop.png" alt="Centro Acquisti">
                            <p>Centro Acquisti</p>
                        </div>
                        <div class="app-icon">
                            <img src="img/dealership.png" alt="Concessionaria">
                            <p>Concessionaria</p>
                        </div>
                    </div>
                </div>

                <!-- Schermata per Trasporti -->
                <?php if ($category == 'TRANSPORT'): ?>
                <div class="swiper-slide" id="transports-dashboard">
                    <h2>Gestione Trasporti</h2>
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Veicoli Disponibili</h5>
                                    <p class="card-text">Gestisci i tuoi veicoli di trasporto.</p>
                                    <button class="btn btn-primary" onclick="window.location.href='manage_vehicles.php'">Visualizza Veicoli</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Contratti di Trasporto</h5>
                                    <p class="card-text">Gestisci i contratti di trasporto.</p>
                                    <button class="btn btn-primary" onclick="window.location.href='manage_contracts.php'">Visualizza Contratti</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Schermata per Energia -->
                <?php if ($category == 'ENERGY'): ?>
                <div class="swiper-slide" id="energy-dashboard">
                    <h2>Gestione Energia</h2>
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Impianti Energetici</h5>
                                    <p class="card-text">Gestisci i tuoi impianti di produzione energetica.</p>
                                    <button class="btn btn-primary" onclick="window.location.href='manage_energy_facilities.php'">Visualizza Impianti</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Distribuzione Energetica</h5>
                                    <p class="card-text">Controlla la distribuzione dell'energia prodotta.</p>
                                    <button class="btn btn-primary" onclick="window.location.href='manage_energy_distribution.php'">Visualizza Distribuzione</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Schermata per Materie Prime -->
                <?php if ($category == 'RAW_MATERIALS'): ?>
                <div class="swiper-slide" id="raw-materials-dashboard">
                    <h2>Gestione Materie Prime</h2>
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Operazioni di Estrazione</h5>
                                    <p class="card-text">Gestisci le operazioni di estrazione delle materie prime.</p>
                                    <button class="btn btn-primary" onclick="window.location.href='manage_extraction_operations.php'">Visualizza Operazioni</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Contratti di Vendita</h5>
                                    <p class="card-text">Gestisci i contratti di vendita delle materie prime.</p>
                                    <button class="btn btn-primary" onclick="window.location.href='manage_sales_contracts.php'">Visualizza Contratti</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="logout.js"></script>
</body>
</html>
