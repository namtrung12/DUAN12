<?php
// File debug để kiểm tra hệ thống
// Truy cập: http://localhost/DU_AN_1/base/debug.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/configs/env.php';
require_once __DIR__ . '/models/BaseModel.php';
require_once __DIR__ . '/models/Product.php';
require_once __DIR__ . '/models/Category.php';

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug - Kiểm tra hệ thống</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .success { color: #0a0; font-weight: bold; }
        .error { color: #c00; font-weight: bold; }
        .warning { color: #f80; font-weight: bold; }
        h1 { color: #333; }
        h2 { color: #666; border-bottom: 2px solid #ef6b45; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background: #ef6b45; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
        .info-box { background: #e3f2fd; border-left: 4px solid #2196f3; padding: 15px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>🔍 Debug - Kiểm tra hệ thống Chill Drink</h1>

    <!-- 1. Kiểm tra cấu hình -->
    <div class="section">
        <h2>1. Cấu hình Database</h2>
        <table>
            <tr><th>Thông số</th><th>Giá trị</th></tr>
            <tr><td>DB_HOST</td><td><?= DB_HOST ?></td></tr>
            <tr><td>DB_PORT</td><td><?= DB_PORT ?></td></tr>
            <tr><td>DB_NAME</td><td><?= DB_NAME ?></td></tr>
            <tr><td>DB_USERNAME</td><td><?= DB_USERNAME ?></td></tr>
            <tr><td>BASE_URL</td><td><?= BASE_URL ?></td></tr>
        </table>
    </div>

    <!-- 2. Kiểm tra kết nối Database -->
    <div class="section">
        <h2>2. Kết nối Database</h2>
        <?php
        try {
            $baseModel = new BaseModel();
            echo "<p class='success'>✅ Kết nối database thành công!</p>";
            
            // Kiểm tra bảng products
            $stmt = $baseModel->pdo->query("SHOW TABLES LIKE 'products'");
            if ($stmt->rowCount() > 0) {
                echo "<p class='success'>✅ Bảng 'products' tồn tại</p>";
            } else {
                echo "<p class='error'>❌ Bảng 'products' không tồn tại! Vui lòng import file SQL</p>";
            }
            
        } catch (Exception $e) {
            echo "<p class='error'>❌ Lỗi kết nối: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>

    <!-- 3. Kiểm tra sản phẩm -->
    <div class="section">
        <h2>3. Thống kê sản phẩm</h2>
        <?php
        try {
            $productModel = new Product();
            
            // Tổng số sản phẩm
            $stmt = $productModel->pdo->query("SELECT COUNT(*) as total FROM products");
            $total = $stmt->fetch()['total'];
            echo "<p>📦 Tổng số sản phẩm trong database: <strong>$total</strong></p>";
            
            // Sản phẩm đang hoạt động
            $stmt = $productModel->pdo->query("SELECT COUNT(*) as active FROM products WHERE status = 1 AND deleted_at IS NULL");
            $active = $stmt->fetch()['active'];
            
            if ($active > 0) {
                echo "<p class='success'>✅ Sản phẩm đang hiển thị: <strong>$active</strong></p>";
            } else {
                echo "<p class='error'>❌ Không có sản phẩm nào đang hiển thị (status=1 và deleted_at IS NULL)</p>";
                echo "<div class='info-box'>";
                echo "<strong>Giải pháp:</strong> Chạy query sau trong phpMyAdmin:<br>";
                echo "<code>UPDATE products SET status = 1, deleted_at = NULL;</code>";
                echo "</div>";
            }
            
            // Sản phẩm bị tắt
            $stmt = $productModel->pdo->query("SELECT COUNT(*) as inactive FROM products WHERE status = 0");
            $inactive = $stmt->fetch()['inactive'];
            if ($inactive > 0) {
                echo "<p class='warning'>⚠️ Sản phẩm bị tắt (status=0): <strong>$inactive</strong></p>";
            }
            
            // Sản phẩm đã xóa
            $stmt = $productModel->pdo->query("SELECT COUNT(*) as deleted FROM products WHERE deleted_at IS NOT NULL");
            $deleted = $stmt->fetch()['deleted'];
            if ($deleted > 0) {
                echo "<p class='warning'>⚠️ Sản phẩm đã xóa: <strong>$deleted</strong></p>";
            }
            
        } catch (Exception $e) {
            echo "<p class='error'>❌ Lỗi: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>

    <!-- 4. Danh sách sản phẩm -->
    <div class="section">
        <h2>4. Danh sách sản phẩm (Top 10)</h2>
        <?php
        try {
            $productModel = new Product();
            $stmt = $productModel->pdo->query("
                SELECT p.id, p.name, p.status, p.deleted_at, p.image, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC 
                LIMIT 10
            ");
            $products = $stmt->fetchAll();
            
            if (empty($products)) {
                echo "<p class='error'>❌ Không có sản phẩm nào trong database!</p>";
                echo "<div class='info-box'>";
                echo "<strong>Giải pháp:</strong> Import file <code>du_an1 (6).sql</code> vào phpMyAdmin";
                echo "</div>";
            } else {
                echo "<table>";
                echo "<tr><th>ID</th><th>Tên</th><th>Danh mục</th><th>Trạng thái</th><th>Đã xóa?</th><th>Ảnh</th></tr>";
                foreach ($products as $p) {
                    $statusText = $p['status'] == 1 ? '<span class="success">Hoạt động</span>' : '<span class="error">Tắt</span>';
                    $deletedText = $p['deleted_at'] ? '<span class="error">Có</span>' : '<span class="success">Không</span>';
                    $imageStatus = $p['image'] ? '✅' : '❌';
                    echo "<tr>";
                    echo "<td>{$p['id']}</td>";
                    echo "<td>" . htmlspecialchars($p['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($p['category_name'] ?? 'N/A') . "</td>";
                    echo "<td>$statusText</td>";
                    echo "<td>$deletedText</td>";
                    echo "<td>$imageStatus</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            
        } catch (Exception $e) {
            echo "<p class='error'>❌ Lỗi: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>

    <!-- 5. Kiểm tra danh mục -->
    <div class="section">
        <h2>5. Danh mục sản phẩm</h2>
        <?php
        try {
            $categoryModel = new Category();
            $stmt = $categoryModel->pdo->query("SELECT COUNT(*) as total FROM categories");
            $totalCat = $stmt->fetch()['total'];
            
            if ($totalCat > 0) {
                echo "<p class='success'>✅ Có $totalCat danh mục</p>";
                
                $categories = $categoryModel->getAll();
                echo "<table>";
                echo "<tr><th>ID</th><th>Tên danh mục</th></tr>";
                foreach ($categories as $cat) {
                    echo "<tr><td>{$cat['id']}</td><td>" . htmlspecialchars($cat['name']) . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='error'>❌ Không có danh mục nào!</p>";
            }
            
        } catch (Exception $e) {
            echo "<p class='error'>❌ Lỗi: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>

    <!-- 6. Test Product Model -->
    <div class="section">
        <h2>6. Test Product Model</h2>
        <?php
        try {
            $productModel = new Product();
            $products = $productModel->getAll();
            
            if (empty($products)) {
                echo "<p class='error'>❌ Method getAll() trả về rỗng!</p>";
                echo "<p>Kiểm tra log lỗi trong file error_log hoặc console</p>";
            } else {
                echo "<p class='success'>✅ Method getAll() hoạt động tốt, trả về " . count($products) . " sản phẩm</p>";
            }
            
        } catch (Exception $e) {
            echo "<p class='error'>❌ Lỗi: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>

    <!-- 7. Hướng dẫn -->
    <div class="section">
        <h2>7. Hướng dẫn khắc phục</h2>
        <div class="info-box">
            <h3>Nếu không có sản phẩm hiển thị:</h3>
            <ol>
                <li>Mở phpMyAdmin</li>
                <li>Chọn database <code>du_an1</code></li>
                <li>Chạy query: <code>UPDATE products SET status = 1, deleted_at = NULL;</code></li>
                <li>Refresh lại trang này để kiểm tra</li>
                <li>Nếu vẫn không được, import lại file <code>du_an1 (6).sql</code></li>
            </ol>
        </div>
        
        <div class="info-box">
            <h3>Các link hữu ích:</h3>
            <ul>
                <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
                <li><a href="<?= BASE_URL ?>?action=products">Danh sách sản phẩm</a></li>
                <li><a href="<?= BASE_URL ?>?action=admin">Trang admin</a></li>
            </ul>
        </div>
    </div>

    <div style="text-align: center; margin: 40px 0; color: #999;">
        <p>Debug page - Chill Drink System</p>
    </div>
</body>
</html>
