<?php
// Start session for flash messages
session_start();

require_once '../src/controllers/ReviewController.php';
$reviewController = new ReviewController();

// Handle POST actions (add, edit, delete)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'addReview') {
        $reviewer = $_POST['reviewer'];
        $comments = $_POST['comments'];
        $date = $_POST['reviewDate'];
        $rating = $_POST['rating'];
        $reviewController->addReview($reviewer, $comments, $date, $rating);
    }

    if ($action === 'editReview') {
        $reviewId = $_POST['reviewId'];
        $reviewer = $_POST['reviewer'];
        $comments = $_POST['comments'];
        $date = $_POST['reviewDate'];
        $rating = $_POST['rating'];
        $reviewController->editReview($reviewId, $reviewer, $comments, $date, $rating);
    }

    if ($action === 'deleteReview') {
        $reviewId = $_POST['reviewId'];
        $reviewController->deleteReview($reviewId);
    }

    // Redirect to prevent form resubmission
    header("Location: review_management.php");
    exit();
}

// Fetch all reviews for displaying in the table
$reviews = $reviewController->listReviews();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Review Management - Employee Performance Tracking System">
    <title>Review Management</title>

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
                        <a class="nav-link" href="goal_management.php">Goals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="review_management.php">Reviews</a>
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
    <h2 class="page-title">Review Management</h2>

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

    <!-- Review List Section -->
    <section class="container my-5">
        <div class="d-flex justify-content-between">
            <h3 class="mb-4">Your Reviews</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReviewModal">Add New Review</button>
        </div>
        <!-- Reviews Table -->
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Reviewer</th>
                    <th>Comments</th>
                    <th>Date</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td><?= $review['reviewer'] ?></td>
                        <td><?= $review['comments'] ?></td>
                        <td><?= $review['review_date'] ?></td>
                        <td><?= $review['rating'] ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editReviewModal" 
                                    data-id="<?= $review['id'] ?>" data-reviewer="<?= $review['reviewer'] ?>"
                                    data-comments="<?= $review['comments'] ?>" data-review_date="<?= $review['review_date'] ?>"
                                    data-rating="<?= $review['rating'] ?>">
                                Edit
                            </button>
                            <form action="review_management.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="deleteReview">
                                <input type="hidden" name="reviewId" value="<?= $review['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Add Review Modal -->
    <div class="modal fade" id="addReviewModal" tabindex="-1" aria-labelledby="addReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReviewModalLabel">Add New Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="review_management.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="addReview">
                        <div class="form-group">
                            <label for="reviewer">Reviewer</label>
                            <input type="text" class="form-control" id="reviewer" name="reviewer" required>
                        </div>
                        <div class="form-group">
                            <label for="comments">Comments</label>
                            <textarea class="form-control" id="comments" name="comments" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="reviewDate">Review Date</label>
                            <input type="date" class="form-control" id="reviewDate" name="reviewDate" required>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Review Modal -->
    <div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editReviewModalLabel">Edit Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="review_management.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="editReview">
                        <input type="hidden" name="reviewId" id="editReviewId">
                        <div class="form-group">
                            <label for="editReviewer">Reviewer</label>
                            <input type="text" class="form-control" id="editReviewer" name="reviewer" required>
                        </div>
                        <div class="form-group">
                            <label for="editComments">Comments</label>
                            <textarea class="form-control" id="editComments" name="comments" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editReviewDate">Review Date</label>
                            <input type="date" class="form-control" id="editReviewDate" name="reviewDate" required>
                        </div>
                        <div class="form-group">
                            <label for="editRating">Rating</label>
                            <input type="number" class="form-control" id="editRating" name="rating" min="1" max="5" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript to handle Edit Modal data population -->
    <script>
        document.querySelectorAll('[data-bs-target="#editReviewModal"]').forEach(button => {
            button.addEventListener('click', function () {
                const reviewId = this.getAttribute('data-id');
                const reviewer = this.getAttribute('data-reviewer');
                const comments = this.getAttribute('data-comments');
                const reviewDate = this.getAttribute('data-review_date');
                const rating = this.getAttribute('data-rating');

                document.getElementById('editReviewId').value = reviewId;
                document.getElementById('editReviewer').value = reviewer;
                document.getElementById('editComments').value = comments;
                document.getElementById('editReviewDate').value = reviewDate;
                document.getElementById('editRating').value = rating;
            });
        });
    </script>

</body>

</html>
