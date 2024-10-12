<?php
require_once '../config/database.php'; // Ensure correct path

class GoalController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Method to list all goals
    public function listGoals() {
        $query = "SELECT * FROM goals";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to add a new goal
    public function addGoal($name, $description, $due_date) {
        $query = "INSERT INTO goals (name, description, due_date) VALUES (:name, :description, :due_date)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':due_date', $due_date);
        
        if ($stmt->execute()) {
            // If the goal was added successfully
            $_SESSION['message'] = "Goal added successfully!";
            $_SESSION['alert_type'] = "success";
            return true;
        } else {
            // If there was an error adding the goal
            $_SESSION['message'] = "Failed to add goal. Please try again.";
            $_SESSION['alert_type'] = "danger";
            return false;
        }
    }

    // Method to delete a goal
    public function deleteGoal($goalId) {
        $query = "DELETE FROM goals WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $goalId);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Goal deleted successfully!";
            $_SESSION['alert_type'] = "success";
            return true;
        } else {
            $_SESSION['message'] = "Failed to delete goal.";
            $_SESSION['alert_type'] = "danger";
            return false;
        }
    }

    // Method to edit a goal
    public function editGoal($goalId, $name, $description, $due_date) {
        $query = "UPDATE goals SET name = :name, description = :description, due_date = :due_date WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $goalId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':due_date', $due_date);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Goal updated successfully!";
            $_SESSION['alert_type'] = "success";
            return true;
        } else {
            $_SESSION['message'] = "Failed to update goal.";
            $_SESSION['alert_type'] = "danger";
            return false;
        }
    }
}
