# 🔧 HƯỚNG DẪN SỬA LỖI SẢN PHẨM KHÔNG HIỂN THỊ

## 📋 Các bước kiểm tra và sửa lỗi

### Bước 1: Kiểm tra hệ thống
Truy cập trang debug để xem chi tiết lỗi:
```
http://localhost/DU_AN_1/base/debug.php
```
(Thay đổi đường dẫn phù hợp với cấu hình của bạn)

### Bước 2: Kiểm tra Database

#### 2.1. Kiểm tra MySQL đã chạy chưa
- Mở XAMPP/WAMP/MAMP
- Đảm bảo MySQL đang chạy (màu xanh)

#### 2.2. Kiểm tra database tồn tại
1. Mở phpMyAdmin: `http://localhost/phpmyadmin`
2. Kiểm tra có database tên `du_an1` không
3. Nếu chưa có, tạo database mới tên `du_an1`

#### 2.3. Import dữ liệu
1. Chọn database `du_an1`
2. Click tab "Import"
3. Chọn file `du_an1 (6).sql`
4. Click "Go" để import

### Bước 3: Kiểm tra dữ liệu sản phẩm

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

### Lỗi 1: "Kết nối database thất bại"
**Nguyên nhân:**
- MySQL chưa chạy
- Thông tin database sai
- Database chưa tồn tại

**Giải pháp:**
1. Bật MySQL trong XAMPP
2. Kiểm tra lại thông tin trong `configs/env.php`
3. Tạo database `du_an1` nếu chưa có

### Lỗi 2: "Không tìm thấy sản phẩm nào"
**Nguyên nhân:**
- Database chưa có dữ liệu
- Tất cả sản phẩm có `status = 0`
- Tất cả sản phẩm đã bị xóa (`deleted_at` không NULL)

**Giải pháp:**
```sql
-- Kích hoạt tất cả sản phẩm
UPDATE products SET status = 1, deleted_at = NULL;
```

### Lỗi 3: "Ảnh sản phẩm không hiển thị"
**Nguyên nhân:**
- File ảnh không tồn tại
- Đường dẫn sai
- Quyền truy cập thư mục

**Giải pháp:**
1. Kiểm tra file ảnh trong `base/assets/uploads/`
2. Đảm bảo tên file trong database khớp với file thực tế
3. Kiểm tra quyền thư mục (755)

### Lỗi 4: "Trang trắng, không có gì hiển thị"
**Nguyên nhân:**
- Lỗi PHP nghiêm trọng
- Thiếu file

**Giải pháp:**
1. Kiểm tra file `error.log`
2. Đảm bảo tất cả file cần thiết tồn tại
3. Kiểm tra syntax PHP

## 📝 Checklist kiểm tra nhanh

- [ ] MySQL đang chạy
- [ ] Database `du_an1` tồn tại
- [ ] File SQL đã được import
- [ ] Có ít nhất 1 sản phẩm với `status=1` và `deleted_at=NULL`
- [ ] File `configs/env.php` có thông tin đúng
- [ ] Thư mục `assets/uploads/` có ảnh sản phẩm
- [ ] Không có lỗi hiển thị trên trang
- [ ] Trang debug.php chạy được

## 🆘 Vẫn không được?

### Giải pháp cuối cùng: Reset toàn bộ

1. **Xóa database cũ:**
```sql
DROP DATABASE IF EXISTS du_an1;
CREATE DATABASE du_an1;
```

2. **Import lại file SQL:**
- Chọn database `du_an1`
- Import file `du_an1 (6).sql`

3. **Kiểm tra lại:**
- Truy cập `debug.php`
- Xem tất cả thông tin có đúng không

4. **Nếu vẫn lỗi:**
- Chụp màn hình trang debug.php
- Chụp màn hình lỗi (nếu có)
- Kiểm tra file error.log

## 📞 Liên hệ hỗ trợ

Nếu vẫn gặp vấn đề, cung cấp thông tin sau:
1. Screenshot trang debug.php
2. Screenshot lỗi (nếu có)
3. Nội dung file error.log
4. Phiên bản PHP, MySQL đang dùng

---

**Lưu ý:** Sau khi sửa xong, có thể xóa file `debug.php` để bảo mật.
