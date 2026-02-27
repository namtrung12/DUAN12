<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=du_an1;charset=utf8mb4", "root", "");
    $stmt = $pdo->query("SELECT k, v FROM settings WHERE k LIKE 'banner_%' ORDER BY k");
    $bannerSettings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $banners = [];
    foreach ($bannerSettings as $key => $value) {
        if (!empty($value) && trim($value) !== '') {
            $banners[] = $value;
        }
    }
} catch (Exception $e) {
    $banners = [];
}
?>

<section class="pt-4 pb-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-[1.05fr_1.35fr] gap-4 lg:gap-5">
            <div class="rounded-[2rem] border border-[#f0d8c8] bg-[#fff7f1] shadow-sm p-6 sm:p-8 lg:p-9 flex flex-col justify-between">
                <div>
                    <p class="inline-flex items-center gap-2 text-xs font-semibold tracking-[0.16em] uppercase text-[#a84a30] bg-[#ffe6d8] border border-[#f4cfbc] rounded-full px-4 py-2">
                        <span class="material-icons text-sm">local_fire_department</span>
                        Đồ uống đặc trưng
                    </p>

                    <h1 class="mt-5 text-[#1f2937] text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-[1.15]">
                        Uống ngon mỗi ngày,
                        <span class="text-[#ef6b45] block mt-1">đặt nhanh trong vài phút</span>
                    </h1>

                    <p class="mt-4 text-[#5b6476] text-base sm:text-lg leading-relaxed max-w-xl">
                        Tùy chỉnh đá, đường, topping rõ ràng trong một màn hình. Theo dõi đơn và tích điểm trong cùng một tài khoản.
                    </p>
                </div>

                <div class="mt-7">
                    <div class="flex flex-wrap gap-3">
                        <a href="<?= BASE_URL ?>?action=products" class="inline-flex items-center gap-2 px-7 py-3 rounded-full bg-primary text-white font-bold hover:brightness-95">
                            Đặt ngay
                            <span class="material-icons text-base">arrow_forward</span>
                        </a>
                        <a href="<?= BASE_URL ?>?action=loyalty-rewards" class="inline-flex items-center gap-2 px-7 py-3 rounded-full border border-[#f0d8c8] bg-white text-[#1f2937] font-semibold hover:bg-[#fff2e8]">
                            Xem ưu đãi
                            <span class="material-icons text-base">loyalty</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-3 gap-3 mt-6">
                        <div class="rounded-2xl border border-[#f0d8c8] bg-white p-3">
                            <p class="text-xs text-[#7d8798] uppercase tracking-[0.08em]">Giao hàng</p>
                            <p class="font-bold text-[#1f2937] mt-1">~30 phút</p>
                        </div>
                        <div class="rounded-2xl border border-[#f0d8c8] bg-white p-3">
                            <p class="text-xs text-[#7d8798] uppercase tracking-[0.08em]">Đánh giá</p>
                            <p class="font-bold text-[#1f2937] mt-1">4.9 / 5</p>
                        </div>
                        <div class="rounded-2xl border border-[#f0d8c8] bg-white p-3">
                            <p class="text-xs text-[#7d8798] uppercase tracking-[0.08em]">Giờ mở</p>
                            <p class="font-bold text-[#1f2937] mt-1">8:00 - 22:00</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative rounded-[2rem] overflow-hidden border border-[#f0d8c8] shadow-xl min-h-[360px] lg:min-h-[520px] bg-[#1f2937]">
                <?php if (!empty($banners)): ?>
                <div class="absolute inset-0">
                    <?php foreach ($banners as $index => $banner): ?>
                    <?php $bannerUrl = (strpos($banner, 'http') === 0) ? $banner : BASE_URL . $banner; ?>
                    <div class="hero-media-slide absolute inset-0 transition-all duration-[1000ms] ease-out <?= $index === 0 ? 'opacity-100 scale-100' : 'opacity-0 scale-105' ?>">
                        <img src="<?= htmlspecialchars($bannerUrl, ENT_QUOTES, 'UTF-8') ?>" alt="Banner <?= $index + 1 ?>" class="w-full h-full object-cover">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="absolute inset-0 bg-gradient-to-br from-[#6a2f1f] via-[#9b3f2d] to-[#ef6b45]"></div>
                <div class="absolute -top-16 -right-20 w-72 h-72 rounded-full bg-[#ffc89f]/30 blur-3xl"></div>
                <div class="absolute -bottom-24 -left-16 w-72 h-72 rounded-full bg-[#ffd9bd]/20 blur-3xl"></div>
                <?php endif; ?>

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/68 via-black/24 to-black/15"
                    style="background: linear-gradient(to top, rgba(0,0,0,0.78), rgba(0,0,0,0.36), rgba(0,0,0,0.2));"
                ></div>

                <div class="relative z-10 h-full p-5 sm:p-6 flex flex-col justify-end">
                    <div class="max-w-lg rounded-2xl bg-black/58 border border-white/25 backdrop-blur-sm p-4 sm:p-5" style="background-color: rgba(0, 0, 0, 0.72);">
                        <p class="text-white/75 text-xs tracking-[0.14em] uppercase">Chill Drink</p>
                        <h3 class="text-white text-xl sm:text-2xl font-bold mt-1 leading-tight">
                            Mỗi ly là một công thức được cá nhân hóa cho bạn
                        </h3>
                    </div>
                </div>

                <?php if (count($banners) > 1): ?>
                <div class="absolute right-5 bottom-5 flex items-center gap-2 z-20">
                    <?php foreach ($banners as $index => $banner): ?>
                    <button onclick="setHeroMediaSlide(<?= $index ?>)" class="hero-media-dot h-2.5 rounded-full transition-all duration-300 border border-white/40 <?= $index === 0 ? 'w-8 bg-white' : 'w-2.5 bg-white/55 hover:bg-white/85' ?>"></button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($banners) && count($banners) > 1): ?>
<script>
let heroMediaIndex = 0;
const heroMediaSlides = document.querySelectorAll('.hero-media-slide');
const heroMediaDots = document.querySelectorAll('.hero-media-dot');
let heroMediaChanging = false;

function drawHeroMediaSlide(index) {
    if (heroMediaChanging) return;
    heroMediaChanging = true;

    heroMediaSlides.forEach((slide, i) => {
        if (i === index) {
            slide.classList.remove('opacity-0', 'scale-105');
            slide.classList.add('opacity-100', 'scale-100');
        } else {
            slide.classList.remove('opacity-100', 'scale-100');
            slide.classList.add('opacity-0', 'scale-105');
        }
    });

    heroMediaDots.forEach((dot, i) => {
        if (i === index) {
            dot.classList.remove('w-2.5', 'bg-white/55');
            dot.classList.add('w-8', 'bg-white');
        } else {
            dot.classList.remove('w-8', 'bg-white');
            dot.classList.add('w-2.5', 'bg-white/55');
        }
    });

    setTimeout(() => {
        heroMediaChanging = false;
    }, 1000);
}

function setHeroMediaSlide(index) {
    heroMediaIndex = index;
    drawHeroMediaSlide(heroMediaIndex);
}

function nextHeroMediaSlide() {
    heroMediaIndex = (heroMediaIndex + 1) % heroMediaSlides.length;
    drawHeroMediaSlide(heroMediaIndex);
}

setInterval(nextHeroMediaSlide, 5200);
</script>
<?php endif; ?>

