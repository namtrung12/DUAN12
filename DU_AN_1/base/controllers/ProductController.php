<?php

class ProductController
{
    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function index()
    {
        /*
         * NGHIỆP VỤ #1 (Bảng phân công): Người dùng xem danh sách sản phẩm.
         * Mục tiêu: hiển thị sản phẩm theo dạng danh sách, có phân trang và hỗ trợ tìm kiếm.
         * Dữ liệu dùng: bảng products (đã lọc status=1, deleted_at IS NULL), categories.
         * Kết quả mong đợi: trang menu có thể duyệt nhanh, giới hạn số lượng theo trang.
         */
        $categories = $this->categoryModel->getAll();
        
        // Phân trang (8 sản phẩm/trang, từ sản phẩm thứ 9 mới phân trang)
        $perPage = 8;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        
        // Xử lý tìm kiếm
        $search = $_GET['search'] ?? '';
        if (!empty($search)) {
            $products = $this->productModel->searchPaginated($search, $page, $perPage);
            $totalProducts = $this->productModel->countSearch($search);
        } else {
            $products = $this->productModel->getAllPaginated($page, $perPage);
            $totalProducts = $this->productModel->countAll();
        }
        
        $totalPages = ceil($totalProducts / $perPage);
        
        require_once PATH_VIEW . 'products/index.php';
    }

    public function byCategory()
    {
        /*
         * NGHIỆP VỤ #1 (mở rộng): lọc danh sách sản phẩm theo danh mục.
         * Kết hợp với phân trang để khi danh mục có nhiều sản phẩm vẫn tải nhanh.
         */
        $categoryId = $_GET['category_id'] ?? 0;
        $category = $this->categoryModel->getById($categoryId);
        
        if (!$category) {
            header('Location: ' . BASE_URL . '?action=products');
            exit;
        }

        $categories = $this->categoryModel->getAll();
        
        // Phân trang (8 sản phẩm/trang, từ sản phẩm thứ 9 mới phân trang)
        $perPage = 8;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $products = $this->productModel->getByCategoryPaginated($categoryId, $page, $perPage);
        $totalProducts = $this->productModel->countByCategory($categoryId);
        $totalPages = ceil($totalProducts / $perPage);
        
        require_once PATH_VIEW . 'products/index.php';
    }

    public function detail()
    {
        /*
         * NGHIỆP VỤ #2: Người dùng xem chi tiết sản phẩm.
         * Màn hình chi tiết gom đủ dữ liệu: thông tin sản phẩm + size + topping + review + điểm đánh giá.
         * Đây là dữ liệu đầu vào quan trọng cho flow "thêm vào giỏ" ở nghiệp vụ #3.
         */
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getById($id);

        if (!$product) {
            header('Location: ' . BASE_URL . '?action=products');
            exit;
        }

        $sizes = $this->productModel->getSizes($id);
        $toppings = $this->productModel->getToppings($id);
        $reviews = $this->productModel->getReviews($id);
        $ratingData = $this->productModel->getAverageRating($id);
        
        $avgRating = $ratingData['avg_rating'] ? round($ratingData['avg_rating'], 1) : 0;
        $reviewCount = $ratingData['review_count'] ?? 0;
        
        require_once PATH_VIEW . 'products/detail.php';
    }
}
