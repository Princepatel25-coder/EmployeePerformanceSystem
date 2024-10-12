<?php
// Start the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Employee Performance Tracking System - Dashboard">
    <title>Performance Tracker Dashboard</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        /* Navbar */
        .navbar {
            background-color: #2e3b55;
            padding: 1rem;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
        }

        .navbar-nav .nav-link {
            color: #fff;
            font-size: 1rem;
            margin-right: 15px;
        }

        .navbar-nav .nav-link:hover {
            color: #ffc107;
        }

        /* Dashboard Cards */
        .card {
            margin: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .card-body a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2e3b55;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .card-body a:hover {
            background-color: #ffc107;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Performance Tracker</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="goal_management.php">Goals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="review_management.php">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="feedback_hub.php">Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="performance_reports.php">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a> <!-- Logout option -->
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Section -->
    <section class="container my-5">
        <h2 class="text-center">Welcome to Employee Performance Tracking System</h2>
        <p class="text-center">Track and manage employee performance through goals, reviews, feedback, and reports.</p>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Goals</h5>
                        <a href="goal_management.php" class="btn btn-primary">View Goals</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Reviews</h5>
                        <a href="review_management.php" class="btn btn-primary">View Reviews</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Feedback Hub</h5>
                        <a href="feedback_hub.php" class="btn btn-primary">View Feedback</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Performance Reports</h5>
                        <a href="performance_reports.php" class="btn btn-primary">View Reports</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer bg-dark text-white text-center py-3">
        <p>&copy; 2024 Employee Performance Tracking System. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
