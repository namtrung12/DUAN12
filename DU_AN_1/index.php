<?php
declare(strict_types=1);

/**
 * Application Entry Point
 * Redirects all root requests to the main application directory
 */

// Normalize path separators and determine root path
$rootPath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');

// Build target URL for redirection
$target = ($rootPath === '' || $rootPath === '.') ? '/base/' : $rootPath . '/base/';

// Perform redirect to application bootstrap
header('Location: ' . $target, true, 302);
exit;
