# 🔧 Hướng dẫn Troubleshooting & Debug

## 📋 Mục lục
- [Kiểm tra hệ thống](#bước-1-kiểm-tra-hệ-thống)
- [Kiểm tra Database](#bước-2-kiểm-tra-database)
- [Kiểm tra dữ liệu](#bước-3-kiểm-tra-dữ-liệu-sản-phẩm)
- [Kiểm tra cấu hình](#bước-4-kiểm-tra-cấu-hình)
- [Xem log lỗi](#bước-5-xem-log-lỗi)
- [Test từng trang](#bước-6-test-từng-trang)
- [Lỗi thường gặp](#-các-lỗi-thường-gặp)

---

## Bước 1: Kiểm tra hệ thống

Truy cập trang debug để xem chi tiết lỗi:
```
http://localhost/DU_AN_1/base/debug.php
```

> Thay đổi đường dẫn phù hợp với cấu hình của bạn

---

## Bước 2: Kiểm tra Database

### 2.1. Kiểm tra MySQL Service
- Mở XAMPP/WAMP/MAMP Control Panel
- Đảm bảo MySQL đang chạy (status màu xanh)
- Nếu chưa chạy, click "Start"

### 2.2. Kiểm tra Database tồn tại
1. Truy cập phpMyAdmin: `http://localhost/phpmyadmin`
2. Kiểm tra database `du_an1` trong danh sách bên trái
3. Nếu chưa có, tạo database mới:
   ```sql
   CREATE DATABASE du_an1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

### 2.3. Import dữ liệu
1. Chọn database `du_an1`
2. Click tab "Import"
3. Chọn file `du_an1 (6).sql`
4. Click "Go" để thực thi import

--- Bước 3: Kiểm tra dữ liệu sản phẩm

#### 3.1. Chạy query kiểm tra
Trong phpMyAdmin, chọn database `du_an1`, vào tab SQL và chạy:

```sql
-- Kiểm tra tổng số sản phẩm
SELECT COUNT(*) as total FROM products;

-- Kiểm tra sản phẩm đang hiển thị
SELECT COUNT(*) as active FROM products 
WHERE status = 1 AND deleted_at IS NULL;

-- Xem chi tiết sản phẩm
SELECT id, name, status, deleted_at FROM products;
```

#### 3.2. Nếu không có sản phẩm nào hiển thị
Chạy query sau để kích hoạt tất cả sản phẩm:

```sql
UPDATE products SET status = 1, deleted_at = NULL;
```

### Bước 4: Kiểm tra cấu hình

#### 4.1. Kiểm tra file `configs/env.php`
Đảm bảo thông tin đúng:
```php
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');  // Để trống nếu không có password
define('DB_NAME', 'du_an1');
```

#### 4.2. Kiểm tra đường dẫn ảnh
- Ảnh sản phẩm phải nằm trong: `base/assets/uploads/`
- Kiểm tra quyền truy cập thư mục (chmod 755)

### Bước 5: Xem log lỗi

#### 5.1. Bật hiển thị lỗi PHP
File `index.php` đã được cập nhật để hiển thị lỗi. Nếu có lỗi sẽ hiện trên màn hình.

#### 5.2. Kiểm tra error log
- Windows: `C:\xampp\apache\logs\error.log`
- Mac: `/Applications/XAMPP/logs/error_log`
- Linux: `/var/log/apache2/error.log`

### Bước 6: Test từng trang

#### 6.1. Trang chủ
```
http://localhost/DU_AN_1/base/
```
Nếu không có sản phẩm, sẽ hiện thông báo cảnh báo màu vàng.

#### 6.2. Trang danh sách sản phẩm
```
http://localhost/DU_AN_1/base/?action=products
```
Nếu không có sản phẩm, sẽ hiện hướng dẫn chi tiết.

#### 6.3. Trang admin
```
http://localhost/DU_AN_1/base/?action=admin-products
```
Kiểm tra danh sách sản phẩm trong admin.

## 🚨 Các lỗi thường gặp

### ❌ Lỗi 1: "Kết nối database thất bại"

**Nguyên nhân:**
- MySQL service chưa được khởi động
- Thông tin kết nối database không chính xác
- Database chưa được tạo

**Giải pháp:**
1. Khởi động MySQL trong XAMPP Control Panel
2. Xác minh thông tin trong `base/configs/env.php`
3. Tạo database `du_an1` nếu chưa tồn tại

---

### ❌ Lỗi 2: "Không tìm thấy sản phẩm nào"

**Nguyên nhân:**
- Database chưa có dữ liệu sản phẩm
- Tất cả sản phẩm có `status = 0` (bị ẩn)
- Sản phẩm đã bị soft delete (`deleted_at IS NOT NULL`)

**Giải pháp:**
```sql
-- Kích hoạt và khôi phục tất cả sản phẩm
UPDATE products 
SET status = 1, deleted_at = NULL 
WHERE 1=1;
```

---

### ❌ Lỗi 3: "Ảnh sản phẩm không hiển thị"

**Nguyên nhân:**
- File ảnh không tồn tại trong thư mục uploads
- Đường dẫn ảnh trong database không chính xác
- Quyền truy cập thư mục bị hạn chế

**Giải pháp:**
1. Kiểm tra file ảnh trong `base/assets/uploads/products/`
2. Đảm bảo tên file trong database khớp với file thực tế
3. Cấp quyền đọc cho thư mục (chmod 755 trên Linux/Mac)

---

### ❌ Lỗi 4: "Trang trắng, không có nội dung"

**Nguyên nhân:**
- Lỗi PHP fatal error
- File bị thiếu hoặc đường dẫn sai
- Syntax error trong code

**Giải pháp:**
1. Kiểm tra Apache error log
2. Xác minh tất cả file cần thiết tồn tại
3. Kiểm tra PHP syntax errors

---

## 📝 Checklist kiểm tra nhanh

- [ ] MySQL service đang chạy
- [ ] Database `du_an1` đã được tạo
- [ ] File SQL đã được import thành công
- [ ] Có ít nhất 1 sản phẩm với `status=1` và `deleted_at=NULL`
- [ ] File `base/configs/env.php` có thông tin kết nối chính xác
- [ ] Thư mục `base/assets/uploads/` chứa ảnh sản phẩm
- [ ] Không có PHP errors hiển thị trên trang
- [ ] Trang `debug.php` chạy và hiển thị thông tin đầy đủ

---

## 🆘 Giải pháp cuối cùng: Reset toàn bộ

Nếu tất cả các bước trên không giải quyết được vấn đề:

### 1. Xóa và tạo lại database
```sql
DROP DATABASE IF EXISTS du_an1;
CREATE DATABASE du_an1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Import lại dữ liệu
- Chọn database `du_an1` trong phpMyAdmin
- Import file `du_an1 (6).sql`
- Đợi quá trình import hoàn tất

### 3. Xác minh lại
- Truy cập `http://localhost/DU_AN_1/base/debug.php`
- Kiểm tra tất cả thông tin hiển thị

### 4. Nếu vẫn gặp lỗi
Thu thập thông tin sau để debug:
- Screenshot trang debug.php
- Screenshot thông báo lỗi (nếu có)
- Nội dung file Apache error.log
- Phiên bản PHP và MySQL đang sử dụng

---

## 📞 Hỗ trợ

Khi cần hỗ trợ, vui lòng cung cấp:
1. Screenshot trang `debug.php`
2. Screenshot thông báo lỗi
3. Nội dung file `error.log`
4. Thông tin môi trường (PHP version, MySQL version, OS)

---

**Lưu ý bảo mật:** Sau khi hoàn tất debug, nên xóa hoặc đổi tên file `debug.php` để tránh lộ thông tin hệ thống.
