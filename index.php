<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register with Email or Google</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="card-title">Login</h3>
                        <form id="login-form">
                            <div class="mb-3">
                                <input type="email" id="login-email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" id="login-password" class="form-control" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Login</button>
                        </form>
                        <hr>
                        <button id="google-signin-button" class="btn btn-danger btn-lg">Sign in with Google</button>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body text-center">
                        <h3 class="card-title">Register</h3>
                        <form id="register-form">
                            <div class="mb-3">
                                <input type="email" id="register-email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" id="register-password" class="form-control" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Firebase and JavaScript -->
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-auth.js"></script>
    <script type="module" src="auth.js"></script>
</body>
</html>
