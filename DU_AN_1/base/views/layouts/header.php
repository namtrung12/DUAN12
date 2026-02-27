<!-- Header Navigation -->
<?php
$siteSettings = get_site_settings();
$siteName = $siteSettings['site_name'] ?? 'Chill Drink';
$siteLogo = $siteSettings['site_logo'] ?? '';
$currentAction = $_GET['action'] ?? '';

$isHome = ($currentAction === '' || $currentAction === 'home');
$isProducts = ($currentAction === 'products' || $currentAction === 'products-by-category' || $currentAction === 'product-detail');
$isOrders = (strpos($currentAction, 'order') === 0 || $currentAction === 'orders');
$isOffers = (strpos($currentAction, 'loyalty') === 0);
?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<script src="<?= BASE_URL ?>assets/js/icon-fallback.js"></script>
<style>
    header .material-symbols-outlined,
    header .material-icons {
        font-weight: normal;
        font-style: normal;
        font-size: 24px;
        line-height: 1;
        letter-spacing: normal;
        text-transform: none;
        display: inline-block;
        white-space: nowrap;
        word-wrap: normal;
        direction: ltr;
        -webkit-font-feature-settings: "liga";
        font-feature-settings: "liga";
        -webkit-font-smoothing: antialiased;
        font-family: "Material Symbols Outlined Local", "Material Symbols Outlined", "Material Icons Local", "Material Icons" !important;
        font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
    }
</style>

<header class="sticky top-0 z-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="bg-white/90 border border-[#f0d8c8] rounded-2xl px-4 sm:px-6 py-3 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <!-- Logo -->
                <a href="<?= BASE_URL ?>" class="flex items-center gap-3 shrink-0" style="text-decoration: none; cursor: pointer;">
                    <?php if (!empty($siteLogo)): ?>
                        <img src="<?= BASE_URL . $siteLogo ?>" alt="<?= htmlspecialchars($siteName) ?>" class="w-12 h-12 object-contain rounded-xl border border-[#f0d8c8] bg-[#fff7f1] p-1">
                    <?php else: ?>
                        <div class="w-12 h-12 rounded-xl bg-primary text-white flex items-center justify-center">
                            <span class="material-icons text-2xl">local_bar</span>
                        </div>
                    <?php endif; ?>
                    <div class="hidden sm:block">
                        <p class="text-sm text-slate-500 leading-none">Fresh Drink Studio</p>
                        <span class="text-xl font-bold text-slate-900 leading-tight"><?= htmlspecialchars($siteName) ?></span>
                    </div>
                </a>

                <!-- Navigation -->
                <nav role="navigation" aria-label="Main menu" class="hidden xl:flex items-center gap-2 p-1 rounded-full bg-[#fff1e8] border border-[#f0d8c8]">
                    <a href="<?= BASE_URL ?>"
                       class="px-4 py-2 rounded-full font-semibold text-sm transition-colors <?= $isHome ? 'bg-primary text-white' : 'text-slate-700 hover:bg-white' ?>">
                        Trang Chủ
                    </a>
                    <a href="<?= BASE_URL ?>?action=products"
                       class="px-4 py-2 rounded-full font-semibold text-sm transition-colors <?= $isProducts ? 'bg-primary text-white' : 'text-slate-700 hover:bg-white' ?>">
                        Sản Phẩm
                    </a>
                    <a href="<?= BASE_URL ?>?action=orders"
                       class="px-4 py-2 rounded-full font-semibold text-sm transition-colors <?= $isOrders ? 'bg-primary text-white' : 'text-slate-700 hover:bg-white' ?>">
                        Đơn Hàng
                    </a>
                    <a href="<?= BASE_URL ?>?action=loyalty-rewards"
                       class="px-4 py-2 rounded-full font-semibold text-sm transition-colors <?= $isOffers ? 'bg-primary text-white' : 'text-slate-700 hover:bg-white' ?>">
                        Ưu Đãi
                    </a>
                </nav>

                <!-- Search -->
                <div class="hidden md:flex items-center flex-1 max-w-md mx-2 lg:mx-5">
                    <form action="<?= BASE_URL ?>" method="GET" class="relative w-full" id="searchForm">
                        <input type="hidden" name="action" value="products" />
                        <input
                            type="text"
                            name="search"
                            id="searchInput"
                            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : '' ?>"
                            placeholder="Tìm món bạn muốn..."
                            class="w-full h-11 pl-11 pr-11 rounded-full border border-[#f0d8c8] bg-[#fffdfb] focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary"
                            autocomplete="off"
                            oninput="handleSearchInput(this.value)"
                        />
                        <button type="submit" class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary cursor-pointer">search</button>
                        <button type="button" id="clearSearch" onclick="clearSearchInput()" class="material-icons absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 cursor-pointer hidden">close</button>

                        <div id="searchSuggestions" class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-lg border border-[#f0d8c8] hidden max-h-96 overflow-y-auto z-50">
                        </div>
                    </form>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <?php if (isset($_SESSION['user'])): ?>
                    <?php
                    $notificationModel = new Notification();
                    $unreadCount = $notificationModel->getUnreadCount($_SESSION['user']['id']);
                    $notifications = $notificationModel->getByUserId($_SESSION['user']['id'], 5);
                    ?>
                    <div class="relative group">
                        <a href="<?= BASE_URL ?>?action=notifications" aria-label="Notifications" class="relative p-2.5 bg-[#fff4ec] hover:bg-[#ffe8da] rounded-full transition-colors inline-block border border-[#f0d8c8]">
                            <span class="material-icons text-slate-700">notifications</span>
                            <?php if ($unreadCount > 0): ?>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold">
                                <?= $unreadCount > 9 ? '9+' : $unreadCount ?>
                            </span>
                            <?php endif; ?>
                        </a>

                        <div class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-lg border border-[#f0d8c8] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="p-3 border-b border-[#f0d8c8] flex justify-between items-center">
                                <h3 class="font-semibold text-slate-900">Thông báo</h3>
                                <?php if ($unreadCount > 0): ?>
                                <button onclick="markAllNotificationsRead(event)" class="text-xs text-primary hover:underline bg-transparent border-0 cursor-pointer p-0">Đánh dấu đã đọc</button>
                                <?php endif; ?>
                            </div>
                            <div class="max-h-80 overflow-y-auto">
                                <?php if (empty($notifications)): ?>
                                <div class="p-4 text-center text-gray-500">
                                    <span class="material-icons text-4xl text-gray-300 mb-2">notifications_off</span>
                                    <p class="text-sm">Chưa có thông báo</p>
                                </div>
                                <?php else: ?>
                                <?php foreach ($notifications as $notif): ?>
                                <a href="<?= BASE_URL ?>?action=notification-read&id=<?= $notif['id'] ?><?= $notif['order_id'] ? '&redirect=order-detail&order_id=' . $notif['order_id'] : '' ?>"
                                   class="block p-3 hover:bg-gray-50 border-b border-[#f4e2d6] <?= !$notif['is_read'] ? 'bg-[#fff4ee]' : '' ?>">
                                    <div class="flex gap-3">
                                        <div class="flex-shrink-0">
                                            <?php if ($notif['type'] === 'order_delivering'): ?>
                                            <span class="material-icons text-cyan-500">local_shipping</span>
                                            <?php elseif ($notif['type'] === 'order_cancelled'): ?>
                                            <span class="material-icons text-red-500">cancel</span>
                                            <?php else: ?>
                                            <span class="material-icons text-primary">info</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-slate-900 <?= !$notif['is_read'] ? '' : 'font-normal' ?>"><?= htmlspecialchars($notif['title'], ENT_QUOTES, 'UTF-8') ?></p>
                                            <p class="text-xs text-gray-500 truncate"><?= htmlspecialchars($notif['message'], ENT_QUOTES, 'UTF-8') ?></p>
                                            <p class="text-xs text-gray-400 mt-1"><?= date('d/m H:i', strtotime($notif['created_at'])) ?></p>
                                        </div>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Cart -->
                    <a href="<?= BASE_URL ?>?action=cart" aria-label="Shopping cart" class="relative p-2.5 bg-[#fff4ec] hover:bg-[#ffe8da] rounded-full transition-colors border border-[#f0d8c8]">
                        <span class="material-icons text-slate-700">shopping_cart</span>
                        <?php if (isset($_SESSION['user'])): ?>
                            <?php
                            $cartModel = new Cart();
                            $cartCount = $cartModel->countItems($_SESSION['user']['id']);
                            if ($cartCount > 0):
                            ?>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold">
                                <?= $cartCount > 9 ? '9+' : $cartCount ?>
                            </span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>

                    <?php if (isset($_SESSION['user'])): ?>
                    <?php
                    $headerUserModel = new User();
                    $headerUser = $headerUserModel->findById($_SESSION['user']['id']);
                    $currentAvatar = $headerUser['avatar'] ?? $_SESSION['user']['avatar'] ?? '';
                    if ($currentAvatar !== ($_SESSION['user']['avatar'] ?? '')) {
                        $_SESSION['user']['avatar'] = $currentAvatar;
                    }
                    ?>
                    <div class="relative group">
                        <button aria-haspopup="true" aria-expanded="false" class="flex items-center gap-2 p-2 hover:bg-[#fff1e8] rounded-xl transition-colors border border-transparent hover:border-[#f0d8c8]">
                            <?php
                            $avatarUrl = !empty($currentAvatar)
                                ? BASE_URL . $currentAvatar
                                : 'https://ui-avatars.com/api/?name=' . urlencode($_SESSION['user']['name']) . '&size=40&background=F2B07A&color=fff';
                            ?>
                            <img src="<?= $avatarUrl ?>" alt="Avatar" class="w-8 h-8 min-w-[32px] rounded-full object-cover border-2 border-[#f0d8c8]">
                            <span class="hidden lg:block text-slate-700 font-semibold">Tài khoản</span>
                            <span class="material-icons text-slate-700 text-sm">expand_more</span>
                        </button>

                        <div class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-lg border border-[#f0d8c8] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="p-4 border-b border-[#f0d8c8]">
                                <p class="font-semibold text-slate-900"><?= htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8') ?></p>
                                <p class="text-sm text-slate-500"><?= htmlspecialchars($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8') ?></p>
                            </div>
                            <div class="py-2">
                                <a href="<?= BASE_URL ?>?action=profile" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 transition-colors">
                                    <span class="material-icons text-slate-600">person</span>
                                    <span class="text-slate-700">Hồ sơ</span>
                                </a>
                                <a href="<?= BASE_URL ?>?action=orders" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 transition-colors">
                                    <span class="material-icons text-slate-600">receipt_long</span>
                                    <span class="text-slate-700">Đơn hàng</span>
                                </a>
                                <a href="<?= BASE_URL ?>?action=loyalty" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 transition-colors">
                                    <span class="material-icons text-slate-600">stars</span>
                                    <span class="text-slate-700">Điểm thưởng</span>
                                </a>
                                <a href="<?= BASE_URL ?>?action=wallet" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 transition-colors">
                                    <span class="material-icons text-slate-600">account_balance_wallet</span>
                                    <span class="text-slate-700">Ví của tôi</span>
                                </a>
                                <?php if ((int) ($_SESSION['user']['role_id'] ?? 0) === 2): ?>
                                <a href="<?= BASE_URL ?>?action=admin" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 transition-colors">
                                    <span class="material-icons text-slate-600">admin_panel_settings</span>
                                    <span class="text-slate-700">Quản trị</span>
                                </a>
                                <?php endif; ?>
                            </div>
                            <div class="border-t border-[#f0d8c8] py-2">
                                <a href="<?= BASE_URL ?>?action=logout" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50 transition-colors text-red-600">
                                    <span class="material-icons">logout</span>
                                    <span>Đăng xuất</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="hidden sm:flex items-center gap-2">
                        <a href="<?= BASE_URL ?>?action=login" class="px-4 py-2 text-slate-700 hover:text-primary font-semibold transition-colors">
                            Đăng nhập
                        </a>
                        <a href="<?= BASE_URL ?>?action=register" class="px-4 py-2 bg-primary text-white rounded-xl font-semibold transition-colors">
                            Đăng ký
                        </a>
                    </div>
                    <?php endif; ?>

                    <!-- Mobile Menu Button -->
                    <button aria-label="Open mobile menu" class="lg:hidden p-2.5 bg-[#fff4ec] hover:bg-[#ffe8da] rounded-xl border border-[#f0d8c8]" onclick="toggleMobileMenu()">
                        <span class="material-icons text-slate-700">menu</span>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden lg:hidden mt-3 border-t border-[#f0d8c8] pt-3">
                <div class="px-1 py-2 space-y-2">
                    <form action="<?= BASE_URL ?>" method="GET" class="relative mb-4">
                        <input type="hidden" name="action" value="products" />
                        <input
                            type="text"
                            name="search"
                            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : '' ?>"
                            placeholder="Tìm món bạn muốn..."
                            class="w-full h-10 pl-10 pr-4 rounded-xl border border-[#f0d8c8] focus:outline-none focus:ring-2 focus:ring-primary/50"
                        />
                        <button type="submit" class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary cursor-pointer">search</button>
                    </form>

                    <a href="<?= BASE_URL ?>" class="block px-4 py-2 text-slate-700 hover:bg-gray-50 rounded-xl">Trang Chủ</a>
                    <a href="<?= BASE_URL ?>?action=products" class="block px-4 py-2 text-slate-700 hover:bg-gray-50 rounded-xl">Sản Phẩm</a>
                    <a href="<?= BASE_URL ?>?action=orders" class="block px-4 py-2 text-slate-700 hover:bg-gray-50 rounded-xl">Đơn Hàng</a>
                    <a href="<?= BASE_URL ?>?action=loyalty-rewards" class="block px-4 py-2 text-slate-700 hover:bg-gray-50 rounded-xl">Ưu Đãi</a>
                    <?php if (!isset($_SESSION['user'])): ?>
                    <a href="<?= BASE_URL ?>?action=login" class="block px-4 py-2 text-slate-700 hover:bg-gray-50 rounded-xl">Đăng nhập</a>
                    <a href="<?= BASE_URL ?>?action=register" class="block px-4 py-2 bg-primary text-white rounded-xl font-semibold text-center">Đăng ký</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
}
</script>

<script>
// Search Autocomplete
let searchTimeout;
const searchInput = document.getElementById('searchInput');
const clearBtn = document.getElementById('clearSearch');
const suggestionsBox = document.getElementById('searchSuggestions');

function handleSearchInput(value) {
    if (value.length > 0) {
        clearBtn?.classList.remove('hidden');
    } else {
        clearBtn?.classList.add('hidden');
        suggestionsBox?.classList.add('hidden');
        return;
    }

    clearTimeout(searchTimeout);

    if (value.length < 2) {
        suggestionsBox?.classList.add('hidden');
        return;
    }

    searchTimeout = setTimeout(() => {
        fetchSuggestions(value);
    }, 300);
}

async function fetchSuggestions(keyword) {
    try {
        const response = await fetch(`<?= BASE_URL ?>api/search-suggestions.php?q=${encodeURIComponent(keyword)}`);
        const products = await response.json();

        if (products.length > 0) {
            displaySuggestions(products);
        } else {
            suggestionsBox.innerHTML = '<div class="p-4 text-center text-gray-500">Không tìm thấy sản phẩm</div>';
            suggestionsBox.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Search error:', error);
    }
}

function displaySuggestions(products) {
    const html = products.map(product => `
        <a href="<?= BASE_URL ?>?action=product-detail&id=${product.id}"
           class="flex items-center gap-3 p-3 hover:bg-gray-50 transition-colors border-b border-[#f4e2d6] last:border-0">
            <img src="<?= BASE_URL ?>assets/uploads/${product.image}"
                 alt="${product.name}"
                 class="w-12 h-12 object-cover rounded-xl"
                 onerror="this.src='https://via.placeholder.com/48'"/>
            <div class="flex-1">
                <h4 class="font-semibold text-sm text-slate-900">${product.name}</h4>
                <p class="text-xs text-gray-500">${product.category_name || ''}</p>
            </div>
            <span class="text-sm font-bold text-primary">${formatPrice(product.min_price)}đ</span>
        </a>
    `).join('');

    suggestionsBox.innerHTML = html;
    suggestionsBox.classList.remove('hidden');
}

function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price);
}

function clearSearchInput() {
    if (searchInput) {
        searchInput.value = '';
        clearBtn?.classList.add('hidden');
        suggestionsBox?.classList.add('hidden');
        searchInput.focus();
    }
}

document.addEventListener('click', (e) => {
    if (!document.getElementById('searchForm')?.contains(e.target)) {
        suggestionsBox?.classList.add('hidden');
    }
});

if (searchInput?.value.length > 0) {
    clearBtn?.classList.remove('hidden');
}

async function markAllNotificationsRead(event) {
    event.preventDefault();
    event.stopPropagation();

    try {
        const response = await fetch('<?= BASE_URL ?>?action=notifications-read-all-ajax', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        });

        if (response.ok) {
            location.reload();
        }
    } catch (error) {
        console.error('Error marking notifications as read:', error);
    }
}
</script>


