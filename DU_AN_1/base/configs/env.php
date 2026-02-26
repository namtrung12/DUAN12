<?php

// Filesystem paths (absolute) to avoid dependency on current working directory.
define('PATH_ROOT', __DIR__ . '/../');
define('PATH_MODEL', PATH_ROOT . 'models/');
define('PATH_CONTROLLER', PATH_ROOT . 'controllers/');
define('PATH_VIEW', PATH_ROOT . 'views/');
define('PATH_ASSETS_UPLOADS', PATH_ROOT . 'assets/uploads/');

// Database configuration.
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'du_an1');

define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);

// Base URL for links and redirects, e.g. /DU_AN_1/DUAN1N2/DUAN1/base/
$baseUrl = null;
$documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
$projectRoot = realpath(PATH_ROOT);

if ($documentRoot !== false && $projectRoot !== false) {
    $documentRootNormalized = str_replace('\\', '/', $documentRoot);
    $projectRootNormalized = str_replace('\\', '/', $projectRoot);

    if (stripos($projectRootNormalized, $documentRootNormalized) === 0) {
        $relativePath = trim(substr($projectRootNormalized, strlen($documentRootNormalized)), '/');
        $baseUrl = '/' . ($relativePath === '' ? '' : $relativePath . '/');
    }
}

if ($baseUrl === null) {
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
    $scriptDir = rtrim($scriptDir, '/');
    $baseUrl = ($scriptDir === '' ? '/' : $scriptDir . '/');
}

define('BASE_URL', $baseUrl);
