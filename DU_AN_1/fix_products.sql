-- Script sửa lỗi sản phẩm không hiển thị
-- Chạy script này trong phpMyAdmin nếu sản phẩm không hiển thị

-- 1. Kiểm tra xem có sản phẩm nào không
SELECT COUNT(*) as total_products FROM products;

-- 2. Kiểm tra sản phẩm đang hiển thị (status=1 và chưa xóa)
SELECT COUNT(*) as active_products FROM products WHERE status = 1 AND deleted_at IS NULL;

-- 3. Xem tất cả sản phẩm và trạng thái
SELECT id, name, status, deleted_at, created_at FROM products;

-- 4. GIẢI PHÁP: Kích hoạt TẤT CẢ sản phẩm (nếu cần)
-- Bỏ comment dòng dưới để chạy
-- UPDATE products SET status = 1, deleted_at = NULL;

-- 5. Kiểm tra lại sau khi sửa
-- SELECT COUNT(*) as active_products_after_fix FROM products WHERE status = 1 AND deleted_at IS NULL;

-- 6. Xem chi tiết sản phẩm với danh mục
SELECT 
    p.id,
    p.name,
    p.status,
    p.deleted_at,
    c.name as category_name,
    p.image
FROM products p
LEFT JOIN categories c ON p.category_id = c.id
WHERE p.status = 1 AND p.deleted_at IS NULL;
