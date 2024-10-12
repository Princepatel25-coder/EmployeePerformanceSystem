<?php
// Start session for flash messages
session_start();

require_once '../src/controllers/GoalController.php';
$goalController = new GoalController();

// Handle POST actions (add, edit, delete)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'addGoal') {
        $name = $_POST['goalName'];
        $description = $_POST['goalDescription'];
        $due_date = $_POST['goalDueDate'];
        $goalController->addGoal($name, $description, $due_date);
    }

    if ($action === 'editGoal') {
        $goalId = $_POST['goalId'];
        $name = $_POST['goalName'];
        $description = $_POST['goalDescription'];
        $due_date = $_POST['goalDueDate'];
        $goalController->editGoal($goalId, $name, $description, $due_date);
    }

    if ($action === 'deleteGoal') {
        $goalId = $_POST['goalId'];
        $goalController->deleteGoal($goalId);
    }

    // Redirect to prevent form resubmission
    header("Location: goal_management.php");
    exit();
}

// Fetch all goals for displaying in the table
$goals = $goalController->listGoals();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Goal Management - Employee Performance Tracking System">
    <title>Goal Management</title>

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

        .page-title {
            margin-top: 20px;
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
        }

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
                        <a class="nav-link active" href="goal_management.php">Goals</a>
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Title -->
    <h2 class="page-title">Goal Management</h2>

    <div class="container mt-3">
        <!-- Flash messages for success/error -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['alert_type'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['alert_type']); ?>
        <?php endif; ?>
    </div>

    <!-- Goal List Section -->
    <section class="container my-5">
        <div class="d-flex justify-content-between">
            <h3 class="mb-4">Your Goals</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGoalModal">Add New Goal</button>
        </div>
        <!-- Goals Table -->
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Goal</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($goals as $goal): ?>
                    <tr>
                        <td><?= $goal['name'] ?></td>
                        <td><?= $goal['description'] ?></td>
                        <td><?= $goal['due_date'] ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editGoalModal" 
                                    data-id="<?= $goal['id'] ?>" data-name="<?= $goal['name'] ?>"
                                    data-description="<?= $goal['description'] ?>" data-due_date="<?= $goal['due_date'] ?>">
                                Edit
                            </button>
                            <form action="goal_management.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="deleteGoal">
                                <input type="hidden" name="goalId" value="<?= $goal['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Add Goal Modal -->
    <div class="modal fade" id="addGoalModal" tabindex="-1" aria-labelledby="addGoalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGoalModalLabel">Add New Goal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="goal_management.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="addGoal">
                        <div class="form-group">
                            <label for="goalName">Goal Name</label>
                            <input type="text" class="form-control" id="goalName" name="goalName" required>
                        </div>
                        <div class="form-group">
                            <label for="goalDescription">Description</label>
                            <textarea class="form-control" id="goalDescription" name="goalDescription" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="goalDueDate">Due Date</label>
                            <input type="date" class="form-control" id="goalDueDate" name="goalDueDate" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Goal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Goal Modal -->
    <div class="modal fade" id="editGoalModal" tabindex="-1" aria-labelledby="editGoalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGoalModalLabel">Edit Goal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="goal_management.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="editGoal">
                        <input type="hidden" name="goalId" id="editGoalId">
                        <div class="form-group">
                            <label for="editGoalName">Goal Name</label>
                            <input type="text" class="form-control" id="editGoalName" name="goalName" required>
                        </div>
                        <div class="form-group">
                            <label for="editGoalDescription">Description</label>
                            <textarea class="form-control" id="editGoalDescription" name="goalDescription" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editGoalDueDate">Due Date</label>
                            <input type="date" class="form-control" id="editGoalDueDate" name="goalDueDate" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Goal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript to handle the Edit Modal data population -->
    <script>
        document.querySelectorAll('[data-bs-target="#editGoalModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const goalId = this.getAttribute('data-id');
                const goalName = this.getAttribute('data-name');
                const goalDescription = this.getAttribute('data-description');
                const goalDueDate = this.getAttribute('data-due_date');

                document.getElementById('editGoalId').value = goalId;
                document.getElementById('editGoalName').value = goalName;
                document.getElementById('editGoalDescription').value = goalDescription;
                document.getElementById('editGoalDueDate').value = goalDueDate;
            });
        });
    </script>

</body>

</html>
