<!DOCTYPE html>
<html class="light" lang="vi">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Chill Drink - Đăng ký</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="<?= BASE_URL ?>assets/css/style.css" rel="stylesheet" />
<style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .material-icons {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#ef6b45",
                        "background-light": "#fff8f3",
                        "text-primary": "#1f2937",
                        "text-secondary": "#5b6476",
                        "accent": "#ffe5d6",
                        "error": "#dc3545",
                    },
                    fontFamily: {
                        "display": ["Poppins", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "0.75rem",
                        "xl": "1rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
</head>

<body class="bg-background-light font-display text-text-primary">
    <?php
    $siteSettings = get_site_settings();
    $siteName = $siteSettings['site_name'] ?? 'Chill Drink';
    $siteLogo = $siteSettings['site_logo'] ?? '';
    ?>
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
            <main class="flex-grow">
                <div class="w-full min-h-screen grid grid-cols-1 lg:grid-cols-2">
                    <div class="flex flex-col items-center justify-center p-6 sm:p-12 order-2 lg:order-1">
                        <div class="w-full max-w-md">
                            <div class="text-center lg:text-left mb-10">
                                <a class="inline-flex items-center gap-3 text-2xl font-bold text-text-primary" href="<?= BASE_URL ?>">
                                    <?php if (!empty($siteLogo)): ?>
                                        <img src="<?= BASE_URL . $siteLogo ?>" alt="<?= htmlspecialchars($siteName) ?>" style="width: 70px; height: 70px; object-fit: contain;">
                                    <?php else: ?>
                                        <span class="material-icons text-primary text-4xl">local_bar</span>
                                    <?php endif; ?>
                                    <span><?= htmlspecialchars($siteName) ?></span>
                                </a>
                            </div>
                            <div class="mb-6">
                                <div class="flex border-b border-gray-200">
                                    <a href="<?= BASE_URL ?>?action=login" class="flex-1 py-3 px-4 text-center font-medium text-text-secondary">Đăng nhập</a>
                                    <a href="<?= BASE_URL ?>?action=register" class="flex-1 py-3 px-4 text-center font-semibold text-primary border-b-2 border-primary">Đăng ký</a>
                                </div>
                            </div>
                            <h1 class="text-text-primary tracking-light text-3xl font-bold leading-tight text-left pb-1">Tạo tài khoản mới</h1>
                            <p class="text-text-secondary text-base font-normal leading-normal pb-6">Đăng ký nhanh để đặt đồ và nhận ưu đãi thành viên.</p>
                            <?php if (isset($_SESSION['errors']['register'])): ?>
                                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg"><?= htmlspecialchars($_SESSION['errors']['register'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php endif; ?>
                            <form action="<?= BASE_URL ?>?action=post-register" method="POST" class="space-y-4">
                                <div class="flex flex-col">
                                    <label class="text-text-primary text-base font-medium leading-normal pb-2" for="name">Họ tên</label>
                                    <input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-text-primary focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-300 bg-background-light h-14 placeholder:text-text-secondary p-4 text-base font-normal leading-normal" id="name" name="name" placeholder="Nhập họ tên" type="text" value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required />
                                    <?php if (isset($_SESSION['errors']['name'])): ?>
                                        <span class="text-error text-sm mt-1"><?= htmlspecialchars($_SESSION['errors']['name'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-text-primary text-base font-medium leading-normal pb-2" for="email">Email</label>
                                    <input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-text-primary focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-300 bg-background-light h-14 placeholder:text-text-secondary p-4 text-base font-normal leading-normal" id="email" name="email" placeholder="Nhập email" type="email" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required />
                                    <?php if (isset($_SESSION['errors']['email'])): ?>
                                        <span class="text-error text-sm mt-1"><?= htmlspecialchars($_SESSION['errors']['email'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-text-primary text-base font-medium leading-normal pb-2" for="phone">Số điện thoại</label>
                                    <input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-text-primary focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-300 bg-background-light h-14 placeholder:text-text-secondary p-4 text-base font-normal leading-normal" id="phone" name="phone" placeholder="Nhập số điện thoại" type="text" value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required />
                                    <?php if (isset($_SESSION['errors']['phone'])): ?>
                                        <span class="text-error text-sm mt-1"><?= htmlspecialchars($_SESSION['errors']['phone'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-text-primary text-base font-medium leading-normal pb-2" for="password">Mật khẩu</label>
                                    <input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-text-primary focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-300 bg-background-light h-14 placeholder:text-text-secondary p-4 text-base font-normal leading-normal" id="password" name="password" placeholder="Nhập mật khẩu" type="password" required />
                                    <?php if (isset($_SESSION['errors']['password'])): ?>
                                        <span class="text-error text-sm mt-1"><?= htmlspecialchars($_SESSION['errors']['password'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-text-primary text-base font-medium leading-normal pb-2" for="confirm_password">Xác nhận mật khẩu</label>
                                    <input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-text-primary focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-300 bg-background-light h-14 placeholder:text-text-secondary p-4 text-base font-normal leading-normal" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" type="password" required />
                                    <?php if (isset($_SESSION['errors']['confirm_password'])): ?>
                                        <span class="text-error text-sm mt-1"><?= htmlspecialchars($_SESSION['errors']['confirm_password'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="w-full h-14 px-6 bg-primary text-white rounded-lg font-semibold text-base shadow-sm hover:bg-opacity-90 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Đăng ký</button>
                            </form>
                            <?php unset($_SESSION['errors'], $_SESSION['old']); ?>
                        </div>
                    </div>
                    <div class="relative hidden lg:flex items-center justify-center bg-accent/40 order-1 lg:order-2">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#ffd8c2] to-[#f8b58c]"></div>
                        <div class="relative w-full max-w-lg p-8">
                            <div class="rounded-3xl border border-white/40 bg-white/55 backdrop-blur-md p-8 shadow-xl">
                                <h3 class="text-2xl font-bold text-slate-900 mb-4">Bắt đầu cùng Chill Drink</h3>
                                <ul class="space-y-3 text-slate-700">
                                    <li class="flex items-center gap-2">
                                        <span class="material-icons text-primary">check_circle</span>
                                        Tạo tài khoản trong chưa tới 1 phút
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="material-icons text-primary">check_circle</span>
                                        Nhận ưu đãi thành viên ngay sau khi đăng ký
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="material-icons text-primary">check_circle</span>
                                        Lưu lịch sử và mua lại đơn hàng dễ dàng
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>

