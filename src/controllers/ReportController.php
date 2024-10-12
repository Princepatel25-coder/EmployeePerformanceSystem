<?php
require_once '../config/database.php';

class ReportController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // List all reports
    public function listReports() {
        $query = "SELECT * FROM reports";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Generate a new report
    public function addReport($title, $description) {
        $query = "INSERT INTO reports (title, description, created_at) VALUES (:title, :description, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a report
    public function deleteReport($reportId) {
        $query = "DELETE FROM reports WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $reportId);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get details of a single report
    public function getReportById($reportId) {
        $query = "SELECT * FROM reports WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $reportId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
