<?php
/**
 * Application Routes Configuration
 * Defines all application routes and middleware filters
 */

use Phroute\Phroute\RouteCollector;

// Get requested URL from query string
$url = !isset($_GET['url']) ? "/" : $_GET['url'];

// Initialize route collector
$router = new RouteCollector();

// Authentication middleware filter
$router->filter('auth', function(){
    if(!isset($_SESSION['auth']) || empty($_SESSION['auth'])){
        header('location: ' . BASE_URL . 'login');
        die;
    }
});

// ============ HOME ROUTE ============
$router->get('/', function(){
    return "trang chủ";
});

// ============ ROUTES CHO SẢN PHẨM ============
// Danh sách sản phẩm
$router->get('list-product', [App\Controllers\ProductController::class, 'index']);
// Tìm kiếm sản phẩm
$router->get('search-product', [App\Controllers\ProductController::class, 'search']);
// Form thêm sản phẩm
$router->get('add-product', [App\Controllers\ProductController::class, 'create']);
// Xử lý thêm sản phẩm
$router->post('store-product', [App\Controllers\ProductController::class, 'store']);
// Form sửa sản phẩm
$router->get('edit-product/{id}', [App\Controllers\ProductController::class, 'edit']);
// Xử lý cập nhật sản phẩm
$router->post('update-product/{id}', [App\Controllers\ProductController::class, 'update']);
// Xóa sản phẩm
$router->get('delete-product/{id}', [App\Controllers\ProductController::class, 'destroy']);

// ============ ROUTES CHO DANH MỤC ============
// Danh sách danh mục
$router->get('list-category', [App\Controllers\CategoryController::class, 'index']);
// Form thêm danh mục
$router->get('add-category', [App\Controllers\CategoryController::class, 'create']);
// Xử lý thêm danh mục
$router->post('store-category', [App\Controllers\CategoryController::class, 'store']);
// Form sửa danh mục
$router->get('edit-category/{id}', [App\Controllers\CategoryController::class, 'edit']);
// Xử lý cập nhật danh mục
$router->post('update-category/{id}', [App\Controllers\CategoryController::class, 'update']);
// Xóa danh mục
$router->get('delete-category/{id}', [App\Controllers\CategoryController::class, 'destroy']);

// ============ DISPATCHER CONFIGURATION ============
// Cache router data for performance optimization
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

// Dispatch request and get response
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);

// Output response
echo $response;