<?php 
session_start();

spl_autoload_register(function ($class) {    
    $fileName = "$class.php";

    $fileModel              = PATH_MODEL . $fileName;
    $fileController         = PATH_CONTROLLER . $fileName;

    if (is_readable($fileModel)) {
        require_once $fileModel;
    } 
    else if (is_readable($fileController)) {
        require_once $fileController;
    }
});

require_once __DIR__ . '/configs/env.php';
require_once __DIR__ . '/configs/helper.php';

// Điều hướng
require_once __DIR__ . '/routes/index.php';
