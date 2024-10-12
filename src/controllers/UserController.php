<?php
session_start();
require_once '../config/db.php'; // Include database connection

class UserController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // User login
    public function login($username, $password) {
        try {
            $sql = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the password
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['username'];
                $_SESSION['role'] = $user['role']; // Store role in session
                header('Location: dashboard.php');
                exit();
            } else {
                $_SESSION['error'] = "Invalid username or password.";
                header('Location: login.php');
                exit();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Handling form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userController = new UserController();
    $userController->login($username, $password);
}
