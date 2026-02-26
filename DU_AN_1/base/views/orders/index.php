<!DOCTYPE html>
<html class="light" lang="vi">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Đơn hàng của tôi - Chill Drink</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <?php include PATH_VIEW . 'layouts/common-head.php'; ?>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#ef6b45",
                        "background-light": "#fff8f3",
                        "text-main": "#333333",
                        "text-secondary": "#888888",
                        "status-success": "#77DD77",
                        "status-processing": "#FFD700",
                        "status-cancelled": "#FF6961",
                    },
                    fontFamily: {
                        "display": ["Poppins", "sans-serif"]
                    },
                },
            },
        }
    </script>
</head>

<body class="bg-background-light text-text-main">
    <?php require_once PATH_VIEW . 'layouts/header.php'; ?>
    <div class="relative flex h-auto min-h-screen w-full flex-col">
        <div class="layout-container flex h-full grow flex-col">
            <main class="flex flex-1 justify-center py-10 px-4">
                <div class="w-full max-w-4xl">
                    <h1 class="text-3xl md:text-4xl font-extrabold mb-6 text-slate-900">Đơn hàng của tôi</h1>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                            <p><?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                    <?php unset($_SESSION['success']);
                    endif; ?>
                    <?php if (isset($_SESSION['errors'])): ?>
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                            <?php foreach ($_SESSION['errors'] as $error): ?>
                                <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php unset($_SESSION['errors']);
                    endif; ?>
                    <?php if (empty($orders)): ?>
                        <div class="bg-white rounded-3xl border border-[#f0d8c8] p-10 text-center shadow-sm">
                            <span class="material-icons text-6xl text-gray-400 mb-4">receipt_long</span>
                            <p class="text-text-secondary text-lg mb-4">Bạn chưa có đơn hàng nào</p>
                            <a href="<?= BASE_URL ?>?action=products" class="inline-flex items-center justify-center h-12 px-6 bg-primary text-white rounded-lg font-semibold hover:bg-opacity-90">Mua sắm ngay</a>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($orders as $order): ?>
                                <?php
                                $statusColors = [
                                    'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Chờ xử lý'],
                                    'processing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Đang xử lý'],
                                    'preparing' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'label' => 'Đang thực hiện'],
                                    'shipped' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'label' => 'Đã giao ĐVVC'],
                                    'delivering' => ['bg' => 'bg-cyan-100', 'text' => 'text-cyan-700', 'label' => 'Đang giao'],
                                    'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Hoàn thành'],
                                    'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Đã hủy'],
                                ];
                                $status = $statusColors[$order['status']] ?? $statusColors['pending'];
                                ?>
                                <div class="bg-white rounded-3xl border border-[#f0d8c8] p-6 shadow-sm">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <p class="font-semibold text-lg">Đơn hàng #<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></p>
                                            <p class="text-sm text-text-secondary">Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                                        </div>
                                        <span class="px-3 py-1 <?= $status['bg'] ?> <?= $status['text'] ?> rounded-full text-sm font-semibold"><?= $status['label'] ?></span>
                                    </div>
                                    <div class="border-t pt-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-text-secondary">Tổng tiền:</span>
                                            <span class="font-bold text-lg text-primary"><?= number_format($order['total'], 0, ',', '.') ?>đ</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-text-secondary">Thanh toán:</span>
                                            <span class="font-medium"><?php
                                                                        switch ($order['payment_method']) {
                                                                            case 'cod':
                                                                                echo 'COD';
                                                                                break;
                                                                            case 'vnpay':
                                                                                echo 'VNPay';
                                                                                break;
                                                                            case 'momo':
                                                                                echo 'Momo';
                                                                                break;
                                                                            case 'card':
                                                                                echo 'Thẻ';
                                                                                break;
                                                                        }
                                                                        ?></span>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex flex-row items-center gap-2">
                                        <a href="<?= BASE_URL ?>?action=order-detail&id=<?= $order['id'] ?>" class="flex-1 text-center px-3 py-2 text-sm bg-[#ffe4d3] text-primary rounded-lg hover:bg-[#ffd7c2] transition-colors font-semibold whitespace-nowrap">Xem chi tiết</a>
                                        <?php if ($order['status'] === 'pending' && ($order['payment_status'] ?? 'pending') === 'pending'): ?>
                                            <a href="<?= BASE_URL ?>?action=order-change-payment&id=<?= $order['id'] ?>" class="flex-1 text-center px-3 py-2 text-sm bg-primary text-white rounded-lg hover:opacity-90 transition-colors font-semibold whitespace-nowrap">Đổi thanh toán</a>
                                        <?php endif; ?>
                                        <?php if ($order['status'] === 'pending' || ($order['status'] === 'processing' && $order['payment_method'] === 'cod')): ?>
                                            <form method="POST" action="<?= BASE_URL ?>?action=order-cancel" class="flex-1" onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này không?');">
                                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>" />
                                                <button type="submit" class="w-full px-3 py-2 text-sm bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition-colors whitespace-nowrap">Hủy đơn hàng</button>
                                            </form>
                                        <?php endif; ?>
                                        <?php if ($order['status'] === 'delivering'): ?>
                                            <form method="POST" action="<?= BASE_URL ?>?action=order-confirm-received" class="flex-1" onsubmit="return confirm('Xác nhận bạn đã nhận được hàng?');">
                                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>" />
                                                <button type="submit" class="w-full px-3 py-2 text-sm bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition-colors whitespace-nowrap">Đã nhận hàng</button>
                                            </form>
                                            <form method="POST" action="<?= BASE_URL ?>?action=order-delivery-cancel" class="flex-1" onsubmit="return confirm('Bạn chắc chắn muốn từ chối nhận / trả hàng cho đơn này?');">
                                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>" />
                                                <input type="hidden" name="cancel_reason" value="Khách từ chối nhận khi đang giao" />
                                                <button type="submit" class="w-full px-3 py-2 text-sm border border-red-300 text-red-600 rounded-lg font-semibold hover:bg-red-50 transition-colors whitespace-nowrap">Từ chối nhận</button>
                                            </form>
                                        <?php endif; ?>
                                        <?php if ($order['status'] === 'completed'): ?>
                                            <a href="<?= BASE_URL ?>?action=order-reorder&order_id=<?= $order['id'] ?>" class="flex-1 text-center px-3 py-2 text-sm bg-primary text-white rounded-lg hover:opacity-90 transition-colors font-semibold whitespace-nowrap">Mua lại</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
</body>

</html>

