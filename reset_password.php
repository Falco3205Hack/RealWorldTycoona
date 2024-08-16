<?php
// Questo script invia un'email di recupero password con un link per reimpostare la password
// Può essere integrato con un servizio di invio email come PHPMailer

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'db_connection.php';
    $email = $_POST['email'];

    // Verifica se l'email esiste
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Invia email di reset
        // Codice per inviare email
        echo "An email has been sent with instructions to reset your password.";
    } else {
        echo "No user found with that email address.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="card-title">Reset Password</h3>
                        <form method="POST">
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Send Reset Link</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
