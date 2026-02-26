<?php
$siteName = 'Chill Drink';
$siteEmail = 'support@chilldrink.vn';
$sitePhone = '1900 xxxx';
$siteAddress = 'Ha Noi, Viet Nam';
$siteLogo = null;

try {
    $pdo = new PDO("mysql:host=localhost;dbname=du_an1;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT k, v FROM settings");
    $settingsData = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $siteName = $settingsData['site_name'] ?? $siteName;
    $siteEmail = $settingsData['contact_email'] ?? $siteEmail;
    $sitePhone = $settingsData['contact_phone'] ?? $sitePhone;
    $siteAddress = $settingsData['site_address'] ?? $siteAddress;
    $siteLogo = $settingsData['site_logo'] ?? $siteLogo;
} catch (Exception $e) {
}
?>

<footer class="text-[#f8fafc] py-14 mt-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-[#334155] bg-[#111827]/95 p-8 md:p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <?php if (!empty($siteLogo)): ?>
                            <img src="<?= BASE_URL . $siteLogo ?>" alt="<?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?>" class="h-12 w-12 rounded-xl object-contain bg-[#1e293b] p-1 border border-[#475569]">
                        <?php else: ?>
                            <div class="w-12 h-12 rounded-xl bg-[#1e293b] border border-[#475569] flex items-center justify-center">
                                <span class="material-icons text-[#f8fafc]">local_bar</span>
                            </div>
                        <?php endif; ?>
                        <div>
                            <p class="text-xs uppercase tracking-[0.18em] text-[#cbd5e1]">Đồ uống đặc trưng</p>
                            <span class="text-xl font-bold text-[#f8fafc]"><?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                    </div>
                    <p class="text-[#e2e8f0] leading-relaxed">Không gian đồ uống hiện đại, tập trung vào chất lượng và tốc độ giao hàng trong ngày.</p>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-4 text-[#f8fafc]">Điều hướng</h4>
                    <ul class="space-y-2">
                        <li><a href="<?= BASE_URL ?>" class="text-[#e2e8f0] hover:text-[#ffffff] transition-colors">Trang chủ</a></li>
                        <li><a href="<?= BASE_URL ?>?action=products" class="text-[#e2e8f0] hover:text-[#ffffff] transition-colors">Sản phẩm</a></li>
                        <li><a href="<?= BASE_URL ?>?action=orders" class="text-[#e2e8f0] hover:text-[#ffffff] transition-colors">Đơn hàng</a></li>
                        <li><a href="<?= BASE_URL ?>?action=loyalty-rewards" class="text-[#e2e8f0] hover:text-[#ffffff] transition-colors">Ưu đãi</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-4 text-[#f8fafc]">Hỗ trợ</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-[#e2e8f0] hover:text-[#ffffff] transition-colors">Chính sách đổi trả</a></li>
                        <li><a href="#" class="text-[#e2e8f0] hover:text-[#ffffff] transition-colors">Điều khoản sử dụng</a></li>
                        <li><a href="#" class="text-[#e2e8f0] hover:text-[#ffffff] transition-colors">Bảo mật thông tin</a></li>
                        <li><a href="#" class="text-[#e2e8f0] hover:text-[#ffffff] transition-colors">Trợ giúp trực tuyến</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-4 text-[#f8fafc]">Liên hệ</h4>
                    <ul class="space-y-3 text-[#e2e8f0]">
                        <li class="flex items-center gap-2">
                            <span class="material-icons text-sm">call</span>
                            <span><?= htmlspecialchars($sitePhone, ENT_QUOTES, 'UTF-8') ?></span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="material-icons text-sm">mail</span>
                            <span><?= htmlspecialchars($siteEmail, ENT_QUOTES, 'UTF-8') ?></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="material-icons text-sm mt-0.5">location_on</span>
                            <span><?= htmlspecialchars($siteAddress, ENT_QUOTES, 'UTF-8') ?></span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-[#334155] mt-8 pt-6 text-center text-[#cbd5e1]">
                <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?>. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<script>
window.addEventListener('load', function() {
    document.querySelectorAll('.material-icons').forEach(function(el) {
        el.setAttribute('translate', 'no');
        el.classList.add('notranslate');
    });
});
</script>

