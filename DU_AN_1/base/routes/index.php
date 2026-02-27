<?php

$action = $_GET['action'] ?? '/';

/*
 * BẢN ĐỒ NGHIỆP VỤ THEO BẢNG PHÂN CÔNG (để tiện vấn đáp):
 * #1  Xem danh sách sản phẩm: products, products-by-category
 * #2  Xem chi tiết sản phẩm: product-detail
 * #3  Thêm vào giỏ hàng: cart-add (và các action cart)
 * #4  Đăng ký/đăng nhập: register, post-register, login, post-login, logout
 * #5  Đặt hàng: checkout, checkout-process, order-success
 * #6  Áp dụng mã giảm giá: cart-apply-coupon, cart-remove-coupon
 * #7  Cộng điểm thưởng sau mua: order-confirm-received (gọi loyalty)
 * #8  Đánh giá sau mua: order-review (admin duyệt qua admin-reviews)
 * #9  Admin CRUD sản phẩm: admin-product-*
 * #10 Admin quản lý đơn hàng: admin-orders, admin-order-update, admin-order-cancel
 * #11 Admin quản lý người dùng: admin-users, admin-user-update-role, admin-users-lock/unlock-multiple
 * #12 Admin quản lý mã giảm giá: admin-coupon-*
 * #13 User xem lịch sử đơn: orders, order-detail
 * #14 User xem điểm/đổi quà: loyalty, loyalty-rewards, loyalty-redeem
 * #15 Admin cấu hình hệ thống: admin-settings, admin-settings-update
 * #16 User theo dõi trạng thái và hủy đơn khi đủ điều kiện: orders, order-detail, order-cancel
 */
match ($action) {
    '/'                     => (new HomeController)->index(),
    'login'                 => (new AuthController)->showLogin(),
    'register'              => (new AuthController)->showRegister(),
    'post-login'            => (new AuthController)->login(),
    'post-register'         => (new AuthController)->register(),
    'logout'                => (new AuthController)->logout(),
    'profile'               => (new ProfileController)->index(),
    'profile-edit'          => (new ProfileController)->edit(),
    'profile-update'        => (new ProfileController)->update(),
    'change-password'       => (new ProfileController)->changePassword(),
    'update-password'       => (new ProfileController)->updatePassword(),
    'update-avatar'         => (new ProfileController)->updateAvatar(),
    'address'               => (new AddressController)->index(),
    'address-create'        => (new AddressController)->create(),
    'address-store'         => (new AddressController)->store(),
    'address-edit'          => (new AddressController)->edit(),
    'address-update'        => (new AddressController)->update(),
    'address-delete'        => (new AddressController)->delete(),
    'address-set-default'   => (new AddressController)->setDefault(),
    'products'              => (new ProductController)->index(),
    'product-detail'        => (new ProductController)->detail(),
    'products-by-category'  => (new ProductController)->byCategory(),
    'cart'                  => (new CartController)->index(),
    'cart-add'              => (new CartController)->add(),
    'cart-update'           => (new CartController)->update(),
    'cart-remove'           => (new CartController)->remove(),
    'cart-remove-multiple'  => (new CartController)->removeMultiple(),
    'cart-set-selected'     => (new CartController)->setSelected(),
    'cart-apply-coupon'     => (new CartController)->applyCoupon(),
    'cart-remove-coupon'    => (new CartController)->removeCoupon(),
    'checkout'              => (new OrderController)->checkout(),
    'checkout-process'      => (new OrderController)->process(),
    'order-success'         => (new OrderController)->success(),
    'orders'                => (new OrderController)->index(),
    'order-detail'          => (new OrderController)->detail(),
    'order-cancel'          => (new OrderController)->cancel(),
    'order-review'          => (new OrderController)->review(),
    'order-reorder'         => (new OrderController)->reorder(),
    'order-change-payment'  => (new OrderController)->changePayment(),
    'order-update-payment'  => (new OrderController)->updatePayment(),
    'order-confirm-received' => (new OrderController)->confirmReceived(),
    'order-delivery-cancel' => (new OrderController)->cancelDuringDelivery(),
    'notifications'         => (new OrderController)->notifications(),
    'notification-read'     => (new OrderController)->readNotification(),
    'notifications-read-all' => (new OrderController)->readAllNotifications(),
    'notifications-read-all-ajax' => (new OrderController)->readAllNotificationsAjax(),
    'loyalty'               => (new LoyaltyController)->index(),
    'loyalty-rewards'       => (new LoyaltyController)->rewards(),
    'loyalty-redeem'        => (new LoyaltyController)->redeem(),
    'wallet'                => (new WalletController)->index(),
    'wallet-deposit'        => (new WalletController)->deposit(),
    'wallet-process-deposit' => (new WalletController)->processDeposit(),
    'admin'                 => (new AdminController)->index(),
    'admin-orders'          => (new AdminController)->orders(),
    'admin-order-update'    => (new AdminController)->updateOrder(),
    'admin-order-cancel'    => (new AdminController)->cancelOrder(),
    'admin-products'        => (new ProductAdminController)->index(),
    'admin-product-create'  => (new ProductAdminController)->create(),
    'admin-product-store'   => (new ProductAdminController)->store(),
    'admin-product-edit'    => (new ProductAdminController)->edit(),
    'admin-product-update'  => (new ProductAdminController)->update(),
    'admin-product-delete'  => (new ProductAdminController)->delete(),
    'admin-product-delete-multiple' => (new ProductAdminController)->deleteMultiple(),
    'admin-users'           => (new AdminController)->users(),
    'admin-toppings'                  => (new ToppingController)->index(),
    'admin-topping-create'            => (new ToppingController)->create(),
    'admin-topping-update'            => (new ToppingController)->update(),
    'admin-topping-delete'            => (new ToppingController)->delete(),
    'admin-topping-delete-multiple'   => (new ToppingController)->deleteMultiple(),
    'admin-categories'                => (new CategoryController)->index(),
    'admin-category-create'           => (new CategoryController)->create(),
    'admin-category-update'           => (new CategoryController)->update(),
    'admin-category-delete'           => (new CategoryController)->delete(),
    'admin-category-delete-multiple'  => (new CategoryController)->deleteMultiple(),
    'admin-settings'                  => (new SettingsController)->index(),
    'admin-settings-update'           => (new SettingsController)->update(),
    'admin-coupons'                   => (new CouponController)->index(),
    'admin-coupon-create'             => (new CouponController)->create(),
    'admin-coupon-store'              => (new CouponController)->store(),
    'admin-coupon-edit'               => (new CouponController)->edit(),
    'admin-coupon-update'             => (new CouponController)->update(),
    'admin-coupon-delete'             => (new CouponController)->delete(),
    'admin-coupon-delete-multiple'    => (new CouponController)->deleteMultiple(),
    'admin-user-update-role'          => (new AdminController)->updateUserRole(),
    'admin-users-lock-multiple'       => (new AdminController)->lockMultipleUsers(),
    'admin-users-unlock-multiple'     => (new AdminController)->unlockMultipleUsers(),
    'admin-reviews'                   => (new AdminController)->reviews(),
    'admin-review-update-status'      => (new AdminController)->updateReviewStatus(),
    default                           => (new HomeController)->index(),
};
