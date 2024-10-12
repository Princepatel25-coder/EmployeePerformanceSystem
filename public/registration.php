<?php
session_start();
require_once '../config/db.php'; // Include database connection

class UserController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Register a new user
    public function register($username, $email, $password, $role) {
        try {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Prepare SQL to insert the user
            $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':role', $role); // Assign role
            $stmt->execute();

            $_SESSION['message'] = "Registration successful! You can now log in.";
            header('Location: login.php');
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = "Registration failed: " . $e->getMessage();
            header('Location: register.php');
            exit();
        }
    }
}

// Handling form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Get the role

    $userController = new UserController();
    $userController->register($username, $email, $password, $role);
}
?>
