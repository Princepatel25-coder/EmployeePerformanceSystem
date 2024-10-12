<?php
// Start session
session_start();

// Include database connection
require_once '../config/database.php';  // Ensure correct path to the database file

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

$error_message = "";
$success_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validate form data
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            $success_message = "Registration successful! You can now log in.";
        } else {
            $error_message = "An error occurred. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Register - Employee Performance Tracking System">
    <title>Register</title>

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

        .register-container {
            margin-top: 50px;
        }

        .register-form {
            max-width: 400px;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .register-form h2 {
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

        .login-btn {
            margin-top: 10px;
        }

        .error-message, .success-message {
            text-align: center;
            margin-bottom: 15px;
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }
    </style>
</head>
<body>

    <div class="container register-container">
        <div class="register-form">
            <h2>Register</h2>

            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?= $error_message ?></p>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
                <p class="success-message"><?= $success_message ?></p>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="employee">Employee</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>

            <!-- Login Button -->
            <div class="login-btn">
                <p class="text-center">Already have an account?</p>
                <a href="login.php" class="btn btn-secondary w-100">Login</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
