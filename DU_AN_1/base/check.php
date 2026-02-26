<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kiểm tra nhanh</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .box { background: white; padding: 20px; margin: 10px 0; border-radius: 8px; border-left: 4px solid #ef6b45; }
        .success { border-left-color: #0a0; }
        .error { border-left-color: #c00; background: #fee; }
        .warning { border-left-color: #f80; background: #ffc; }
        pre { background: #f4f4f4; padding: 10px; overflow: auto; }
        h2 { margin-top: 0; color: #333; }
    </style>
</head>
<body>
    <h1>🔍 Kiểm tra nhanh hệ thống</h1>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Kiểm tra file config
echo '<div class="box">';
echo '<h2>1. File cấu hình</h2>';
if (file_exists(__DIR__ . '/configs/env.php')) {
    require_once __DIR__ . '/configs/env.php';
    echo '<p>✅ File env.php tồn tại</p>';
    echo '<pre>';
    echo "DB_HOST: " . DB_HOST . "\n";
    echo "DB_PORT: " . DB_PORT . "\n";
    echo "DB_NAME: " . DB_NAME . "\n";
    echo "DB_USERNAME: " . DB_USERNAME . "\n";
    echo '</pre>';
} else {
    echo '<p>❌ Không tìm thấy file env.php</p>';
}
echo '</div>';

// 2. Kiểm tra kết nối
echo '<div class="box">';
echo '<h2>2. Kết nối Database</h2>';
try {
    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_PORT, DB_NAME);
    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo '<p>✅ Kết nối database thành công!</p>';
    
    // Kiểm tra bảng
    $stmt = $pdo->query("SHOW TABLES LIKE 'products'");
    if ($stmt->rowCount() > 0) {
        echo '<p>✅ Bảng products tồn tại</p>';
    } else {
        echo '<p class="error">❌ Bảng products KHÔNG tồn tại! Vui lòng import file SQL</p>';
    }
    
} catch (PDOException $e) {
    echo '<div class="error">';
    echo '<p>❌ Lỗi kết nối database:</p>';
    echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
    echo '<p><strong>Giải pháp:</strong></p>';
    echo '<ol>';
    echo '<li>Kiểm tra MySQL đã chạy chưa (XAMPP/WAMP)</li>';
    echo '<li>Kiểm tra database "du_an1" đã tồn tại chưa</li>';
    echo '<li>Kiểm tra username/password trong configs/env.php</li>';
    echo '</ol>';
    echo '</div>';
    echo '</div>';
    die();
}
echo '</div>';

// 3. Đếm sản phẩm
echo '<div class="box">';
echo '<h2>3. Thống kê sản phẩm</h2>';
try {
    // Tổng số
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM products");
    $total = $stmt->fetch()['total'];
    echo "<p>📦 Tổng số sản phẩm: <strong>$total</strong></p>";
    
    if ($total == 0) {
        echo '<div class="error">';
        echo '<p>❌ Database không có sản phẩm nào!</p>';
        echo '<p><strong>Giải pháp:</strong> Import file <code>du_an1 (6).sql</code> vào phpMyAdmin</p>';
        echo '</div>';
    } else {
        // Sản phẩm active
        $stmt = $pdo->query("SELECT COUNT(*) as active FROM products WHERE status = 1 AND deleted_at IS NULL");
        $active = $stmt->fetch()['active'];
        
        if ($active > 0) {
            echo "<p>✅ Sản phẩm đang hiển thị: <strong>$active</strong></p>";
        } else {
            echo '<div class="warning">';
            echo '<p>⚠️ Không có sản phẩm nào đang hiển thị!</p>';
            echo '<p><strong>Nguyên nhân:</strong> Tất cả sản phẩm có status=0 hoặc đã bị xóa</p>';
            echo '<p><strong>Giải pháp:</strong> Chạy query sau trong phpMyAdmin:</p>';
            echo '<pre>UPDATE products SET status = 1, deleted_at = NULL;</pre>';
            echo '</div>';
        }
        
        // Sản phẩm inactive
        $stmt = $pdo->query("SELECT COUNT(*) as inactive FROM products WHERE status = 0");
        $inactive = $stmt->fetch()['inactive'];
        if ($inactive > 0) {
            echo "<p>⚠️ Sản phẩm bị tắt: <strong>$inactive</strong></p>";
        }
        
        // Sản phẩm đã xóa
        $stmt = $pdo->query("SELECT COUNT(*) as deleted FROM products WHERE deleted_at IS NOT NULL");
        $deleted = $stmt->fetch()['deleted'];
        if ($deleted > 0) {
            echo "<p>⚠️ Sản phẩm đã xóa: <strong>$deleted</strong></p>";
        }
    }
    
} catch (PDOException $e) {
    echo '<p class="error">❌ Lỗi: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
echo '</div>';

// 4. Danh sách sản phẩm
if ($total > 0) {
    echo '<div class="box">';
    echo '<h2>4. Danh sách sản phẩm (Top 10)</h2>';
    try {
        $stmt = $pdo->query("
            SELECT id, name, status, deleted_at, image 
            FROM products 
            ORDER BY id DESC 
            LIMIT 10
        ");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo '<table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">';
        echo '<tr style="background: #ef6b45; color: white;">';
        echo '<th>ID</th><th>Tên</th><th>Status</th><th>Deleted</th><th>Hiển thị?</th></tr>';
        
        foreach ($products as $p) {
            $canShow = ($p['status'] == 1 && $p['deleted_at'] == null);
            $rowColor = $canShow ? '#e8f5e9' : '#ffebee';
            
            echo "<tr style='background: $rowColor'>";
            echo "<td>{$p['id']}</td>";
            echo "<td>" . htmlspecialchars($p['name']) . "</td>";
            echo "<td>" . ($p['status'] == 1 ? '✅ Active' : '❌ Inactive') . "</td>";
            echo "<td>" . ($p['deleted_at'] ? '❌ Đã xóa' : '✅ OK') . "</td>";
            echo "<td>" . ($canShow ? '✅ CÓ' : '❌ KHÔNG') . "</td>";
            echo "</tr>";
        }
        
        echo '</table>';
        
    } catch (PDOException $e) {
        echo '<p class="error">❌ Lỗi: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    echo '</div>';
}

// 5. Test Model
echo '<div class="box">';
echo '<h2>5. Test Product Model</h2>';
if (file_exists(__DIR__ . '/models/BaseModel.php') && file_exists(__DIR__ . '/models/Product.php')) {
    require_once __DIR__ . '/models/BaseModel.php';
    require_once __DIR__ . '/models/Product.php';
    
    try {
        $productModel = new Product();
        $products = $productModel->getAll();
        
        echo '<p>✅ Product Model load thành công</p>';
        echo '<p>📦 Method getAll() trả về: <strong>' . count($products) . '</strong> sản phẩm</p>';
        
        if (empty($products)) {
            echo '<div class="warning">';
            echo '<p>⚠️ Method getAll() trả về rỗng!</p>';
            echo '<p>Điều này có nghĩa là không có sản phẩm nào thỏa điều kiện: status=1 AND deleted_at IS NULL</p>';
            echo '</div>';
        } else {
            echo '<p>✅ Sản phẩm sẽ hiển thị trên trang web!</p>';
        }
        
    } catch (Exception $e) {
        echo '<p class="error">❌ Lỗi: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
} else {
    echo '<p class="error">❌ Không tìm thấy file Model</p>';
}
echo '</div>';

// 6. Kết luận
echo '<div class="box">';
echo '<h2>6. Kết luận</h2>';
if (isset($active) && $active > 0) {
    echo '<p style="color: #0a0; font-size: 18px; font-weight: bold;">✅ HỆ THỐNG HOẠT ĐỘNG TỐT!</p>';
    echo '<p>Sản phẩm sẽ hiển thị trên trang web.</p>';
    echo '<p><a href="' . BASE_URL . '" style="color: #ef6b45; font-weight: bold;">→ Xem trang chủ</a></p>';
    echo '<p><a href="' . BASE_URL . '?action=products" style="color: #ef6b45; font-weight: bold;">→ Xem danh sách sản phẩm</a></p>';
} else {
    echo '<p style="color: #c00; font-size: 18px; font-weight: bold;">❌ CẦN SỬA LỖI!</p>';
    echo '<p><strong>Chạy query sau trong phpMyAdmin:</strong></p>';
    echo '<pre style="background: #ffe; border: 2px solid #f80; padding: 15px;">UPDATE products SET status = 1, deleted_at = NULL;</pre>';
    echo '<p>Sau đó refresh lại trang này.</p>';
}
echo '</div>';
?>

</body>
</html>
