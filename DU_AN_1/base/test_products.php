<?php
// Test script đơn giản
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== TEST KẾT NỐI VÀ SẢN PHẨM ===\n\n";

// 1. Test require files
echo "1. Đang load files...\n";
require_once __DIR__ . '/configs/env.php';
echo "   ✓ env.php loaded\n";

require_once __DIR__ . '/models/BaseModel.php';
echo "   ✓ BaseModel.php loaded\n";

require_once __DIR__ . '/models/Product.php';
echo "   ✓ Product.php loaded\n";

// 2. Test database config
echo "\n2. Cấu hình Database:\n";
echo "   - Host: " . DB_HOST . "\n";
echo "   - Port: " . DB_PORT . "\n";
echo "   - Database: " . DB_NAME . "\n";
echo "   - Username: " . DB_USERNAME . "\n";

// 3. Test kết nối
echo "\n3. Đang kết nối database...\n";
try {
    $product = new Product();
    echo "   ✓ Kết nối thành công!\n";
} catch (Exception $e) {
    echo "   ✗ LỖI: " . $e->getMessage() . "\n";
    die();
}

// 4. Test query trực tiếp
echo "\n4. Kiểm tra bảng products:\n";
try {
    $stmt = $product->pdo->query("SELECT COUNT(*) as total FROM products");
    $total = $stmt->fetch()['total'];
    echo "   - Tổng số sản phẩm: $total\n";
    
    $stmt = $product->pdo->query("SELECT COUNT(*) as active FROM products WHERE status = 1 AND deleted_at IS NULL");
    $active = $stmt->fetch()['active'];
    echo "   - Sản phẩm đang hoạt động: $active\n";
    
    if ($active == 0) {
        echo "\n   ⚠️ CẢNH BÁO: Không có sản phẩm nào đang hoạt động!\n";
        echo "   Chạy query sau để sửa:\n";
        echo "   UPDATE products SET status = 1, deleted_at = NULL;\n";
    }
} catch (Exception $e) {
    echo "   ✗ LỖI: " . $e->getMessage() . "\n";
}

// 5. Test method getAll()
echo "\n5. Test method Product::getAll():\n";
try {
    $products = $product->getAll();
    echo "   - Số sản phẩm trả về: " . count($products) . "\n";
    
    if (empty($products)) {
        echo "   ✗ Method getAll() trả về rỗng!\n";
    } else {
        echo "   ✓ Method getAll() hoạt động tốt!\n";
        echo "\n   Danh sách sản phẩm:\n";
        foreach ($products as $p) {
            echo "   - [{$p['id']}] {$p['name']} (Status: {$p['status']})\n";
        }
    }
} catch (Exception $e) {
    echo "   ✗ LỖI: " . $e->getMessage() . "\n";
}

echo "\n=== KẾT THÚC TEST ===\n";
?>
