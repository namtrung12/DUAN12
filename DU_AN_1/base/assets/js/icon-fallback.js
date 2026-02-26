(function () {
    if (window.__chillDrinkIconFallbackLoaded) {
        return;
    }
    window.__chillDrinkIconFallbackLoaded = true;

    var NS = "http://www.w3.org/2000/svg";
    var ICONS = {
        search: '<circle cx="11" cy="11" r="7"></circle><path d="m21 21-4.3-4.3"></path>',
        search_off: '<circle cx="11" cy="11" r="7"></circle><path d="m21 21-4.3-4.3"></path><path d="M3 3l18 18"></path>',
        close: '<path d="M18 6 6 18"></path><path d="m6 6 12 12"></path>',
        add: '<path d="M12 5v14"></path><path d="M5 12h14"></path>',
        delete: '<path d="M4 7h16"></path><path d="M10 11v6"></path><path d="M14 11v6"></path><path d="M6 7l1 13h10l1-13"></path><path d="M9 7V4h6v3"></path>',
        edit: '<path d="M12 20h9"></path><path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4Z"></path>',
        info: '<circle cx="12" cy="12" r="9"></circle><path d="M12 10v6"></path><path d="M12 7h.01"></path>',
        cancel: '<circle cx="12" cy="12" r="9"></circle><path d="m15 9-6 6"></path><path d="m9 9 6 6"></path>',
        check_circle: '<circle cx="12" cy="12" r="9"></circle><path d="m8.8 12.4 2.3 2.3 4.2-4.5"></path>',
        star: '<path d="m12 3.6 2.6 5.2 5.8.8-4.2 4.1 1 5.8L12 16.9 6.8 19.5l1-5.8-4.2-4.1 5.8-.8z"></path>',
        stars: '<path d="m12 3.6 2.6 5.2 5.8.8-4.2 4.1 1 5.8L12 16.9 6.8 19.5l1-5.8-4.2-4.1 5.8-.8z"></path>',
        arrow_back: '<path d="M19 12H5"></path><path d="m12 19-7-7 7-7"></path>',
        arrow_forward: '<path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>',
        chevron_left: '<path d="m15 18-6-6 6-6"></path>',
        chevron_right: '<path d="m9 18 6-6-6-6"></path>',
        expand_more: '<path d="m6 9 6 6 6-6"></path>',
        menu: '<path d="M4 6h16"></path><path d="M4 12h16"></path><path d="M4 18h16"></path>',
        notifications: '<path d="M6.8 9.5a5.2 5.2 0 1 1 10.4 0v3.2l1.6 2.7H5.2l1.6-2.7z"></path><path d="M10 17.5a2 2 0 0 0 4 0"></path>',
        notifications_off: '<path d="M6.8 9.5a5.2 5.2 0 1 1 10.4 0v3.2l1.6 2.7H5.2l1.6-2.7z"></path><path d="M10 17.5a2 2 0 0 0 4 0"></path><path d="M3 3l18 18"></path>',
        shopping_cart: '<circle cx="9" cy="19" r="1.4"></circle><circle cx="17" cy="19" r="1.4"></circle><path d="M3 5h2l2.2 9h10.8l2-7H7.2"></path>',
        shopping_bag: '<path d="M6 8h12l-1 12H7L6 8Z"></path><path d="M9 8a3 3 0 1 1 6 0"></path>',
        person: '<circle cx="12" cy="8" r="3.3"></circle><path d="M5 20a7 7 0 0 1 14 0"></path>',
        group: '<circle cx="9" cy="8.5" r="2.5"></circle><circle cx="16" cy="9.5" r="2.2"></circle><path d="M3.5 19a5.5 5.5 0 0 1 11 0"></path><path d="M14 19a4.5 4.5 0 0 1 7 0"></path>',
        people: '<circle cx="9" cy="8.5" r="2.5"></circle><circle cx="16" cy="9.5" r="2.2"></circle><path d="M3.5 19a5.5 5.5 0 0 1 11 0"></path><path d="M14 19a4.5 4.5 0 0 1 7 0"></path>',
        local_shipping: '<rect x="2.5" y="7" width="11" height="8" rx="1.5"></rect><path d="M13.5 9h3l2.5 2.7V15h-5.5"></path><circle cx="7" cy="17" r="1.8"></circle><circle cx="17" cy="17" r="1.8"></circle>',
        account_balance: '<path d="M3 9h18"></path><path d="M4 20h16"></path><path d="M6 9v9"></path><path d="M10 9v9"></path><path d="M14 9v9"></path><path d="M18 9v9"></path><path d="m12 3 9 4H3z"></path>',
        account_balance_wallet: '<rect x="3" y="6.5" width="18" height="11" rx="2"></rect><path d="M15 11h6v3h-6a1.5 1.5 0 0 1 0-3Z"></path>',
        payments: '<rect x="3" y="6.5" width="18" height="11" rx="2"></rect><path d="M3 10h18"></path><path d="M7 14h3"></path>',
        dashboard: '<rect x="3" y="3" width="8" height="8" rx="1.5"></rect><rect x="13" y="3" width="8" height="8" rx="1.5"></rect><rect x="3" y="13" width="8" height="8" rx="1.5"></rect><rect x="13" y="13" width="8" height="8" rx="1.5"></rect>',
        inventory_2: '<path d="M3 7h18l-2 4H5z"></path><path d="M5 11h14v8H5z"></path><path d="M10 15h4"></path>',
        category: '<rect x="3" y="3" width="7" height="7" rx="1.3"></rect><rect x="14" y="3" width="7" height="7" rx="1.3"></rect><rect x="3" y="14" width="7" height="7" rx="1.3"></rect><rect x="14" y="14" width="7" height="7" rx="1.3"></rect>',
        cake: '<path d="M4 11h16v9H4z"></path><path d="M6 11V8a2 2 0 0 1 4 0v3"></path><path d="M10 11V8a2 2 0 0 1 4 0v3"></path><path d="M14 11V8a2 2 0 0 1 4 0v3"></path>',
        receipt_long: '<rect x="6" y="3" width="12" height="18" rx="1.5"></rect><path d="M9 8h6"></path><path d="M9 12h6"></path><path d="M9 16h4"></path>',
        rate_review: '<path d="M4 5h16v10H8l-4 4z"></path><path d="M9 9h6"></path>',
        confirmation_number: '<path d="M3 9a2 2 0 0 0 0 6v3h18v-3a2 2 0 0 0 0-6V6H3z"></path><path d="M12 6v12"></path>',
        settings: '<circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1 1 0 0 0 .2 1.1l.1.1a2 2 0 0 1-2.8 2.8l-.1-.1a1 1 0 0 0-1.1-.2 1 1 0 0 0-.6.9V20a2 2 0 0 1-4 0v-.1a1 1 0 0 0-.6-.9 1 1 0 0 0-1.1.2l-.1.1a2 2 0 0 1-2.8-2.8l.1-.1a1 1 0 0 0 .2-1.1 1 1 0 0 0-.9-.6H4a2 2 0 0 1 0-4h.1a1 1 0 0 0 .9-.6 1 1 0 0 0-.2-1.1l-.1-.1a2 2 0 0 1 2.8-2.8l.1.1a1 1 0 0 0 1.1.2 1 1 0 0 0 .6-.9V4a2 2 0 0 1 4 0v.1a1 1 0 0 0 .6.9 1 1 0 0 0 1.1-.2l.1-.1a2 2 0 0 1 2.8 2.8l-.1.1a1 1 0 0 0-.2 1.1 1 1 0 0 0 .9.6H20a2 2 0 0 1 0 4h-.1a1 1 0 0 0-.9.6z"></path>',
        logout: '<path d="M15 17l5-5-5-5"></path><path d="M20 12H9"></path><path d="M12 19H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h7"></path>',
        local_bar: '<path d="M6 4h12l-3.2 8.5A3 3 0 0 1 12 14.5a3 3 0 0 1-2.8-2L6 4z"></path><path d="M12 14.5V20"></path><path d="M9 20h6"></path>',
        local_fire_department: '<path d="M12 3c2 3.2 5 4.7 5 8.3A5 5 0 0 1 7 12c0-2.6 1.5-4.6 3.2-6.3.6 1.6 1.6 2.6 1.6 2.6S13 6.9 12 3z"></path>',
        loyalty: '<path d="M12 21 4 13a5 5 0 0 1 7-7l1 1 1-1a5 5 0 0 1 7 7z"></path>',
        location_on: '<path d="M12 21s7-6.4 7-11a7 7 0 1 0-14 0c0 4.6 7 11 7 11z"></path><circle cx="12" cy="10" r="2.5"></circle>',
        location_off: '<path d="M12 21s7-6.4 7-11a7 7 0 0 0-11.8-5"></path><path d="M5.6 7.2A7 7 0 0 0 5 10c0 4.6 7 11 7 11"></path><path d="M3 3l18 18"></path>',
        call: '<path d="M5.5 4.5c1.5 3.1 3.9 5.5 7 7l2-2a1.2 1.2 0 0 1 1.2-.3c1 .3 2 .4 3 .4a1.3 1.3 0 0 1 1.3 1.3V18a2 2 0 0 1-2 2C9.2 20 4 14.8 4 8a2 2 0 0 1 2-2h1.2a1.3 1.3 0 0 1 1.3 1.3c0 1 .1 2 .4 3a1.2 1.2 0 0 1-.3 1.2z"></path>',
        mail: '<rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m4 7 8 6 8-6"></path>',
        note: '<path d="M6 3h9l4 4v14H6z"></path><path d="M15 3v4h4"></path><path d="M9 12h6"></path><path d="M9 16h6"></path>',
        image_not_supported: '<rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m3 3 18 18"></path><path d="m8 14 2-2 3 3"></path><path d="m14 13 2-2 2 2"></path>',
        lock: '<rect x="5" y="11" width="14" height="10" rx="2"></rect><path d="M8 11V8a4 4 0 1 1 8 0v3"></path>',
        lock_open: '<rect x="5" y="11" width="14" height="10" rx="2"></rect><path d="M8 11V8a4 4 0 0 1 7-2.5"></path>',
        visibility: '<path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z"></path><circle cx="12" cy="12" r="2.5"></circle>',
        visibility_off: '<path d="M2 12s3.5-6 10-6c1.8 0 3.4.4 4.8 1"></path><path d="M22 12s-3.5 6-10 6c-1.8 0-3.4-.4-4.8-1"></path><path d="M3 3l18 18"></path>',
        cloud_upload: '<path d="M8 18h8a4 4 0 0 0 0-8 6 6 0 0 0-11.2-1.8A4 4 0 0 0 8 18z"></path><path d="M12 16V9"></path><path d="m9.5 11.5 2.5-2.5 2.5 2.5"></path>',
        photo_camera: '<path d="M4 8h3l1.5-2h7L17 8h3v10H4z"></path><circle cx="12" cy="13" r="3"></circle>',
        local_offer: '<path d="M20 10 12 2H4v8l8 8z"></path><circle cx="7.5" cy="6.5" r="1"></circle>',
        sell: '<path d="M20 10 12 2H4v8l8 8z"></path><circle cx="7.5" cy="6.5" r="1"></circle>',
        redeem: '<rect x="3" y="10" width="18" height="11" rx="2"></rect><path d="M3 14h18"></path><path d="M12 10v11"></path><path d="M8.5 10a2 2 0 1 1 0-4c2 0 3.5 4 3.5 4"></path><path d="M15.5 10a2 2 0 1 0 0-4c-2 0-3.5 4-3.5 4"></path>',
        schedule: '<circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path>'
    };

    function buildSvg(name, className) {
        var paths = ICONS[name];
        if (!paths) {
            return null;
        }

        var svg = document.createElementNS(NS, "svg");
        svg.setAttribute("viewBox", "0 0 24 24");
        svg.setAttribute("fill", "none");
        svg.setAttribute("stroke", "currentColor");
        svg.setAttribute("stroke-width", "1.9");
        svg.setAttribute("stroke-linecap", "round");
        svg.setAttribute("stroke-linejoin", "round");
        svg.setAttribute("width", "1em");
        svg.setAttribute("height", "1em");
        svg.setAttribute("aria-hidden", "true");
        if (className) {
            svg.setAttribute("class", className);
        }
        svg.innerHTML = paths;
        return svg;
    }

    function hydrateIcons(root) {
        var context = root || document;
        context.querySelectorAll(".material-icons, .material-symbols-outlined").forEach(function (el) {
            var iconName = (el.textContent || "").trim();
            if (!iconName || !/^[a-z0-9_]+$/i.test(iconName)) {
                return;
            }

            var className = (el.getAttribute("class") || "")
                .split(/\s+/)
                .filter(function (c) {
                    return c && c !== "material-icons" && c !== "material-symbols-outlined";
                })
                .join(" ");

            var svg = buildSvg(iconName, className);
            if (!svg) {
                return;
            }

            if (el.id) {
                svg.id = el.id;
            }
            if (el.getAttribute("style")) {
                svg.setAttribute("style", el.getAttribute("style") + ";vertical-align:middle;");
            } else {
                svg.setAttribute("style", "vertical-align:middle;");
            }
            if (el.getAttribute("title")) {
                svg.setAttribute("title", el.getAttribute("title"));
            }

            el.replaceWith(svg);
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", function () {
            hydrateIcons(document);
        });
    } else {
        hydrateIcons(document);
    }

    var observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            if (mutation.type === "childList") {
                mutation.addedNodes.forEach(function (node) {
                    if (node && node.nodeType === 1) {
                        hydrateIcons(node);
                    }
                });
            }
        });
    });

    window.addEventListener("load", function () {
        if (document.body) {
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        }
    });
})();
