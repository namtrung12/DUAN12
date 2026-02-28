<?php
/**
 * Base Model Class
 * Provides database connection and common functionality for all models
 */

class BaseModel
{
    protected $table;
    public $pdo;

    /**
     * Initialize database connection
     * @throws PDOException If connection fails
     */
    public function __construct()
    {
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_PORT, DB_NAME);

        try {
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
        } catch (PDOException $e) {
            $this->displayConnectionError($e);
        }
    }

    /**
     * Display detailed connection error for debugging
     * @param PDOException $e Exception object
     */
    private function displayConnectionError(PDOException $e)
    {
        echo "<div style='background: #fee; border: 2px solid #c00; padding: 20px; margin: 20px; border-radius: 8px;'>";
        echo "<h2 style='color: #c00;'>❌ Lỗi kết nối Database</h2>";
        echo "<p><strong>Thông báo:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>Host:</strong> " . DB_HOST . "</p>";
        echo "<p><strong>Port:</strong> " . DB_PORT . "</p>";
        echo "<p><strong>Database:</strong> " . DB_NAME . "</p>";
        echo "<p><strong>Username:</strong> " . DB_USERNAME . "</p>";
        echo "<hr>";
        echo "<p><strong>Hướng dẫn khắc phục:</strong></p>";
        echo "<ol>";
        echo "<li>Kiểm tra MySQL/MariaDB đã chạy chưa</li>";
        echo "<li>Kiểm tra tên database 'du_an1' đã tồn tại chưa</li>";
        echo "<li>Import file SQL: du_an1 (6).sql vào phpMyAdmin</li>";
        echo "<li>Kiểm tra username/password trong file configs/env.php</li>";
        echo "</ol>";
        echo "</div>";
        die();
    }

    /**
     * Close database connection
     */
    public function __destruct()
    {
        $this->pdo = null;
    }
}
