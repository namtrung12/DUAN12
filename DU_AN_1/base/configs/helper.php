<?php
/**
 * Helper Functions
 * Common utility functions used throughout the application
 */

// Ensure configuration constants are available when this file is loaded directly
if (!defined('PATH_ASSETS_UPLOADS') || !defined('DB_HOST') || !defined('BASE_URL')) {
    require_once __DIR__ . '/env.php';
}

/**
 * Debug helper - prints data and stops execution
 * @param mixed $data Data to debug
 */
if (!function_exists('debug')) {
    function debug($data)
    {
        echo '<pre>';
        print_r($data);
        die;
    }
}

/**
 * Upload file to specified folder
 * @param string $folder Target folder name
 * @param array $file File data from $_FILES
 * @return string Relative path to uploaded file
 * @throws Exception If upload fails
 */
if (!function_exists('upload_file')) {
    function upload_file($folder, $file)
    {
        // Create directory if not exists
        $uploadDir = PATH_ASSETS_UPLOADS . $folder;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Generate unique filename
        $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
        $filename = time() . '-' . uniqid() . '.' . $extension;
        $targetFile = $folder . '/' . $filename;
        $fullPath = PATH_ASSETS_UPLOADS . $targetFile;

        // Move uploaded file
        if (move_uploaded_file($file["tmp_name"], $fullPath)) {
            return $targetFile;
        }

        throw new Exception('Upload file không thành công! Path: ' . $fullPath);
    }
}

/**
 * Get site settings from database
 * @return array Site settings key-value pairs
 */
if (!function_exists('get_site_settings')) {
    function get_site_settings()
    {
        if (!isset($GLOBALS['site_settings_loaded'])) {
            try {
                $pdo = new PDO(
                    sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME),
                    DB_USERNAME,
                    DB_PASSWORD,
                    DB_OPTIONS
                );
                $stmt = $pdo->query("SELECT * FROM settings");
                $settingsData = $stmt->fetchAll();
                $GLOBALS['siteSettings'] = [];
                foreach ($settingsData as $row) {
                    $GLOBALS['siteSettings'][$row['k']] = $row['v'];
                }
                $GLOBALS['site_settings_loaded'] = true;
            } catch (Exception $e) {
                $GLOBALS['siteSettings'] = [];
                $GLOBALS['site_settings_loaded'] = true;
            }
        }
        return $GLOBALS['siteSettings'];
    }
}
