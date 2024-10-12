<?php
require_once '../src/controllers/ReportController.php';
$reportController = new ReportController();
$reports = $reportController->listReports();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Performance Reports - Employee Performance Tracking System">
    <title>Performance Reports</title>

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

        /* Page Title */
        .page-title {
            margin-top: 20px;
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
        }

        /* Report Table */
        .table thead th {
            background-color: #2e3b55;
            color: white;
        }

        .btn-primary {
            background-color: #2e3b55;
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        /* Form styling */
        .form-control {
            margin-bottom: 15px;
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
                        <a class="nav-link" href="index.php">Dashboard</a>
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
                        <a class="nav-link active" href="performance_reports.php">Reports</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Title -->
    <h2 class="page-title">Performance Reports</h2>

    <!-- Reports Section -->
    <section class="container my-5">
        <div class="d-flex justify-content-between">
            <h3 class="mb-4">Your Reports</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReportModal">Generate New Report</button>
        </div>
        <!-- Reports Table -->
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Report Title</th>
                    <th>Description</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?= $report['title'] ?></td>
                        <td><?= $report['description'] ?></td>
                        <td><?= $report['created_at'] ?></td>
                        <td>
                            <a href="view_report.php?id=<?= $report['id'] ?>" class="btn btn-info btn-sm">View</a>
                            <form action="../src/controllers/ReportController.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="deleteReport">
                                <input type="hidden" name="reportId" value="<?= $report['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Add Report Modal -->
    <div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReportModalLabel">Generate New Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../src/controllers/ReportController.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="addReport">
                        <div class="form-group">
                            <label for="reportTitle">Report Title</label>
                            <input type="text" class="form-control" id="reportTitle" name="reportTitle" required>
                        </div>
                        <div class="form-group">
                            <label for="reportDescription">Description</label>
                            <textarea class="form-control" id="reportDescription" name="reportDescription" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
