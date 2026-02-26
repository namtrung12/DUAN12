<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Chill Drink - Signature Drinks, Fast Delivery</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <?php include PATH_VIEW . 'layouts/common-head.php'; ?>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#ef6b45",
                        "background-light": "#fff8f3",
                    },
                    borderRadius: {
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-background-light">
    <?php include PATH_VIEW . 'layouts/header.php'; ?>

    <?php if (isset($_SESSION['success'])): ?>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="p-4 bg-green-100 text-green-700 rounded-xl border border-green-200 flex items-center justify-between">
            <span><?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?></span>
            <button onclick="this.parentElement.parentElement.remove()" class="text-green-700 hover:text-green-900">✕</button>
        </div>
    </div>
    <?php unset($_SESSION['success']); endif; ?>

    <?php include PATH_VIEW . 'layouts/hero.php'; ?>

    <?php
    $categoryModel = new Category();
    $categories = $categoryModel->getAll();
    $productModel = new Product();
    $allProducts = $productModel->getAll();
    
    // Debug: Hiển thị thông tin
    if (empty($allProducts)) {
        echo "<div style='background: #ffc; border: 2px solid #fa0; padding: 15px; margin: 20px; border-radius: 8px;'>";
        echo "<strong>⚠️ CẢNH BÁO:</strong> Không có sản phẩm nào trong database!<br>";
        echo "Vui lòng kiểm tra:<br>";
        echo "1. Database 'du_an1' đã được import chưa?<br>";
        echo "2. Bảng 'products' có dữ liệu không?<br>";
        echo "3. Các sản phẩm có status=1 và deleted_at=NULL không?<br>";
        echo "</div>";
    }
    
    $featuredProducts = array_slice($allProducts, 0, 4);
    $bestSellerProducts = array_slice($allProducts, 4, 4);
    ?>

    <section class="pb-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-white border border-[#f0d8c8] shadow-sm p-6 md:p-8">
                <div class="flex items-center justify-between gap-3 flex-wrap mb-6">
                    <div>
                        <p class="uppercase tracking-[0.18em] text-xs text-slate-500 font-semibold">Khám phá theo gu</p>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-1">Danh mục sản phẩm</h2>
                    </div>
                    <a href="<?= BASE_URL ?>?action=products" class="inline-flex items-center gap-2 text-primary font-semibold hover:underline">
                        Xem tất cả
                        <span class="material-icons text-base">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <?php
                    $categoryData = [
                        'Trà' => ['icon' => 'psychiatry', 'bg' => 'bg-[#fff0dc]'],
                        'Trà sữa' => ['icon' => 'coffee_maker', 'bg' => 'bg-[#ffe8dc]'],
                        'Cà phê' => ['icon' => 'coffee', 'bg' => 'bg-[#fce8db]'],
                        'Sinh tố' => ['icon' => 'blender', 'bg' => 'bg-[#ffe9e2]'],
                        'Nước ép' => ['icon' => 'nutrition', 'bg' => 'bg-[#fff3df]'],
                    ];
                    foreach ($categories as $category):
                        $data = ['icon' => 'local_cafe', 'bg' => 'bg-[#fff2e8]'];
                        foreach ($categoryData as $catName => $catData) {
                            if (stripos($category['name'], $catName) !== false) {
                                $data = $catData;
                                break;
                            }
                        }
                    ?>
                    <a href="<?= BASE_URL ?>?action=products-by-category&category_id=<?= $category['id'] ?>"
                       class="group rounded-2xl border border-[#f0d8c8] p-4 bg-white hover:bg-[#fff7f2] transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 <?= $data['bg'] ?> rounded-xl flex items-center justify-center mb-3 border border-[#f0d8c8]">
                            <span class="material-icons text-primary text-2xl"><?= $data['icon'] ?></span>
                        </div>
                        <h3 class="font-semibold text-slate-900 group-hover:text-primary line-clamp-1">
                            <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-6 gap-3 flex-wrap">
                <div>
                    <p class="uppercase tracking-[0.18em] text-xs text-slate-500 font-semibold">Gợi ý hôm nay</p>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-1">Sản phẩm nổi bật</h2>
                </div>
                <a href="<?= BASE_URL ?>?action=products" class="inline-flex items-center gap-2 text-primary font-semibold hover:underline">
                    Mở menu
                    <span class="material-icons text-base">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <?php foreach ($featuredProducts as $product): ?>
                <?php
                $sizes = $productModel->getSizes($product['id']);
                $minPrice = !empty($sizes) ? min(array_column($sizes, 'price')) : 0;
                ?>
                <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['id'] ?>"
                   class="group rounded-3xl overflow-hidden border border-[#f0d8c8] bg-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="h-56 bg-[#fff2e9] overflow-hidden">
                        <img src="<?= BASE_ASSETS_UPLOADS . htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8') ?>"
                             alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'"/>
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-slate-900 mb-2 line-clamp-1"><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p class="text-primary font-extrabold text-xl mb-4"><?= number_format($minPrice, 0, ',', '.') ?>đ</p>
                        <div class="w-full text-center py-3 bg-[#ffe4d3] text-primary rounded-xl font-semibold group-hover:bg-[#ffd7c2] transition-colors">
                            Xem chi tiết
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="pb-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl border border-[#f0d8c8] overflow-hidden bg-[#1f2937]">
                <div class="p-6 md:p-8 flex items-start justify-between gap-3 flex-wrap">
                    <div>
                        <p class="uppercase tracking-[0.18em] text-xs text-white/60 font-semibold">Bán chạy</p>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-white mt-1">Sản phẩm bán chạy</h2>
                    </div>
                    <span class="inline-flex px-3 py-1 rounded-full bg-white/10 border border-white/20 text-white/85 text-sm">Cập nhật mỗi ngày</span>
                </div>

                <div class="px-6 md:px-8 pb-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <?php
                    $saleDiscounts = [20, 15, 25, 18];
                    foreach ($bestSellerProducts as $index => $product):
                        $sizes = $productModel->getSizes($product['id']);
                        $minPrice = !empty($sizes) ? min(array_column($sizes, 'price')) : 0;
                        $discount = $saleDiscounts[$index] ?? 20;
                        $originalPrice = $minPrice * (100 / (100 - $discount));
                    ?>
                    <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['id'] ?>"
                       class="group rounded-2xl bg-white/95 overflow-hidden border border-white/20 hover:bg-white transition-all duration-300 hover:-translate-y-1">
                        <div class="relative h-52 bg-[#ffe7d7] overflow-hidden">
                            <img src="<?= BASE_ASSETS_UPLOADS . htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8') ?>"
                                 alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'"/>
                            <div class="absolute top-3 left-3 bg-primary text-white px-3 py-1 rounded-full text-xs font-bold">
                                -<?= $discount ?>%
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-900 mb-1 line-clamp-1"><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-gray-400 line-through text-sm"><?= number_format($originalPrice, 0, ',', '.') ?>đ</span>
                                <span class="text-primary font-extrabold text-lg"><?= number_format($minPrice, 0, ',', '.') ?>đ</span>
                            </div>
                            <div class="w-full text-center py-2.5 bg-[#ffe4d3] text-primary rounded-xl font-semibold group-hover:bg-[#ffd7c2] transition-colors">
                                Đặt ngay
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-white border border-[#f0d8c8] p-6 md:p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
                    <div>
                        <p class="uppercase tracking-[0.18em] text-xs text-slate-500 font-semibold">Ưu đãi thành viên</p>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-1 mb-2">Nhận ưu đãi độc quyền</h2>
                        <p class="text-slate-600">Để lại email để nhận mã giảm giá theo tuần, menu mới và ưu đãi sinh nhật.</p>
                    </div>
                    <form class="flex flex-col sm:flex-row gap-3" onsubmit="return handleNewsletterSubmit(event)">
                        <input
                            type="email"
                            placeholder="Nhập email của bạn"
                            required
                            class="flex-1 h-12 px-4 rounded-xl border border-[#f0d8c8] focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                        />
                        <button
                            type="submit"
                            class="h-12 px-7 bg-primary text-white rounded-xl font-semibold whitespace-nowrap">
                            Đăng ký
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php
                $features = [
                    ['icon' => 'verified', 'title' => 'Nguyên liệu thật', 'desc' => 'Kiểm soát chất lượng mỗi ngày'],
                    ['icon' => 'local_shipping', 'title' => 'Giao nhanh', 'desc' => 'Tối đa 30 phút nội thành'],
                    ['icon' => 'loyalty', 'title' => 'Tích điểm', 'desc' => 'Đổi quà sau mỗi đơn hàng'],
                    ['icon' => 'support_agent', 'title' => 'Hỗ trợ 24/7', 'desc' => 'Phản hồi nhanh qua hotline'],
                ];
                foreach ($features as $feature):
                ?>
                <div class="rounded-2xl bg-white border border-[#f0d8c8] p-5 text-center">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-[#ffe9dc] border border-[#f0d8c8] flex items-center justify-center">
                        <span class="material-icons text-primary text-2xl"><?= $feature['icon'] ?></span>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-1"><?= $feature['title'] ?></h3>
                    <p class="text-slate-600 text-sm"><?= $feature['desc'] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php require_once PATH_VIEW . 'layouts/footer.php'; ?>

    <script>
    function handleNewsletterSubmit(event) {
        event.preventDefault();
        const email = event.target.querySelector('input[type="email"]').value;
        alert('Cảm ơn bạn đã đăng ký! Ưu đãi sẽ được gửi tới: ' + email);
        event.target.reset();
        return false;
    }
    </script>
    <script src="<?= BASE_URL ?>assets/js/main.js"></script>
</body>
</html>


