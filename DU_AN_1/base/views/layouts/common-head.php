<!-- Common Head - Include this in all pages -->
<link href="<?= BASE_URL ?>assets/css/style.css" rel="stylesheet"/>
<link href="<?= BASE_URL ?>assets/css/animations.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
<script src="<?= BASE_URL ?>assets/js/icon-fallback.js"></script>
<style>
    .material-icons,
    .material-symbols-outlined {
        font-family: "Material Symbols Outlined Local", "Material Symbols Outlined", "Material Icons Local", "Material Icons" !important;
        -webkit-font-feature-settings: "liga";
        font-feature-settings: "liga";
        font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
    }
</style>
<script>
    (function () {
        var iconMap = new Map();

        function saveIconNames() {
            document.querySelectorAll('.material-icons, .material-symbols-outlined').forEach(function (el) {
                var text = el.textContent.trim();
                if (text && /^[a-z_]+$/.test(text)) {
                    iconMap.set(el, text);
                    el.setAttribute('data-icon', text);
                    el.setAttribute('translate', 'no');
                    el.classList.add('notranslate');
                }
            });
        }

        function restoreIconNames() {
            document.querySelectorAll('.material-icons[data-icon], .material-symbols-outlined[data-icon]').forEach(function (el) {
                var originalIcon = el.getAttribute('data-icon');
                if (originalIcon && el.textContent.trim() !== originalIcon) {
                    el.textContent = originalIcon;
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', saveIconNames);
        } else {
            saveIconNames();
        }

        window.addEventListener('load', function () {
            saveIconNames();
            setTimeout(restoreIconNames, 500);
            setTimeout(restoreIconNames, 1000);
            setTimeout(restoreIconNames, 2000);
        });

        var observer = new MutationObserver(function () {
            restoreIconNames();
        });

        document.addEventListener('DOMContentLoaded', function () {
            observer.observe(document.body, {
                childList: true,
                subtree: true,
                characterData: true
            });
        });
    })();
</script>
