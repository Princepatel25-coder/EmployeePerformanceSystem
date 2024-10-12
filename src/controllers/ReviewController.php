<?php
require_once '../config/database.php';

class ReviewController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Method to list all reviews
    public function listReviews() {
        $query = "SELECT * FROM reviews";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to add a new review
    public function addReview($reviewer, $comments, $review_date, $rating) {
        $query = "INSERT INTO reviews (reviewer, comments, review_date, rating) VALUES (:reviewer, :comments, :review_date, :rating)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':reviewer', $reviewer);
        $stmt->bindParam(':comments', $comments);
        $stmt->bindParam(':review_date', $review_date);
        $stmt->bindParam(':rating', $rating);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Review added successfully!";
            $_SESSION['alert_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to add review.";
            $_SESSION['alert_type'] = "danger";
        }
    }

    // Method to edit a review
    public function editReview($reviewId, $reviewer, $comments, $review_date, $rating) {
        $query = "UPDATE reviews SET reviewer = :reviewer, comments = :comments, review_date = :review_date, rating = :rating WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $reviewId);
        $stmt->bindParam(':reviewer', $reviewer);
        $stmt->bindParam(':comments', $comments);
        $stmt->bindParam(':review_date', $review_date);
        $stmt->bindParam(':rating', $rating);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Review updated successfully!";
            $_SESSION['alert_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to update review.";
            $_SESSION['alert_type'] = "danger";
        }
    }

    // Method to delete a review
    public function deleteReview($reviewId) {
        $query = "DELETE FROM reviews WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $reviewId);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Review deleted successfully!";
            $_SESSION['alert_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to delete review.";
            $_SESSION['alert_type'] = "danger";
        }
    }
}
