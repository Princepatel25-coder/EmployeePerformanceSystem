<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Display content based on user role
if ($_SESSION['role'] == 'manager') {
    echo "Welcome, Manager {$_SESSION['user']}! Here is your manager dashboard.";
    // Display manager-specific content
} else {
    echo "Welcome, Employee {$_SESSION['user']}! Here is your employee dashboard.";
    // Display employee-specific content
}
?>

<a href="logout.php">Logout</a>
