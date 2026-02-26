<?php
session_start();
require_once "controllers/ProductController.php";
require_once "controllers/CategoryController.php";
$url = isset($_GET['action']) ? $_GET['action'] : "/";
$productController = new ProductController();
$categoryController = new CategoryController();
switch($url){
    case '/':
        $productController->listProduct();
        break;
    case 'add-product':
        $productController->addProduct();
        break;
    case 'edit-product':
        $productController->editProduct();
        break;
    case 'delete-product':
        $productController->deleteProduct();
        break;
    case 'list-category':
        $categoryController->listCategory();
        break;
    case 'edit-category':
        $categoryController->editCategory();
        break;
    case 'add-category':
        $categoryController->addCategory();
        break;
    case 'delete-category':
        $categoryController->deleteCategory();
        break;
    default:
        echo "trang ko ton tai";
        break;
}
?>