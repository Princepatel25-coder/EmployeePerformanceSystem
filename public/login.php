<?php
// Start session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Include database connection
require_once '../config/database.php';


$database = new Database();
$db = $database->getConnection();

$error_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database query to fetch user data
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists and verify password
    if ($user && password_verify($password, $user['password'])) {
        // Set session and redirect to dashboard
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role']; // You can store the role if needed
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login - Employee Performance Tracking System">
    <title>Login</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
        }

        .login-container {
            margin-top: 50px;
        }

        .login-form {
            max-width: 400px;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #2e3b55;
            border: none;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #ffc107;
        }

        .register-btn {
            margin-top: 10px;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container login-container">
        <div class="login-form">
            <h2>Login</h2>

            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?= $error_message ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <!-- Register Button -->
            <div class="register-btn">
                <p class="text-center">Don't have an account?</p>
                <a href="register.php" class="btn btn-secondary w-100">Register</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
