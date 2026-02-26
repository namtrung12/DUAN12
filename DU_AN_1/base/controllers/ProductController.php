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