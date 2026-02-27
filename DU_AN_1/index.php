<?php
declare(strict_types=1);

// Redirect legacy root entrypoint to the active app bootstrap.
$rootPath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
$target = ($rootPath === '' || $rootPath === '.') ? '/base/' : $rootPath . '/base/';

header('Location: ' . $target, true, 302);
exit;
