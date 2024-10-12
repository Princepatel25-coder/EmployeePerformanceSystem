<?php
class Database {
    private $host = "localhost";        // Database host (e.g., localhost)
    private $db_name = "performance_tracker";  // Name of your database
    private $username = "root";         // Your database username
    private $password = "";             // Your database password
    private $conn;

    // Get the database connection
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
