<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Sale;
use App\Http\Middleware\Ship;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::match(['get', 'post'], '/admin/login', [App\Http\Controllers\Admin\User\AccountController::class, 'loginForm'])->name('admin.users.login');
Route::match(['get', 'post'], '/admin/forgot-password', [App\Http\Controllers\Admin\User\Password\PasswordController::class, 'passwordForm'])->name('admin.users.forgot');
Route::get('admin/forgot-password-complete', [App\Http\Controllers\Admin\User\Password\PasswordController::class, 'forgotPasswordComplete'])->name('admin.users.forgotPasswordComplete');
Route::get('admin/reset-password/{email}/{token}', [App\Http\Controllers\Admin\User\Password\PasswordController::class, 'getToken'])->name('admin.users.getToken');
Route::post('admin/resetPassword', [App\Http\Controllers\Admin\User\Password\PasswordController::class, 'resetPassword'])->name('admin.users.resetPassword');
Route::get('/admin/change-password-complete', [App\Http\Controllers\Admin\User\Password\PasswordController::class, 'changePasswordComplete'])->name('admin.users.changePasswordComplete');

Route::middleware([Admin::class])->prefix('/admin')->group(function () {
    Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');
    Route::get('/logout', [App\Http\Controllers\Admin\User\AccountController::class, 'logout'])->name('admin.users.logout'); //đăng xuất
    Route::post('/get-dashboard', [App\Http\Controllers\Admin\HomeController::class, 'getDashboard'])->name('admin.home.getDashboard');

    Route::post('/get-general-statistical', [App\Http\Controllers\Admin\HomeController::class, 'getGeneralStatistical'])->name('admin.home.getGeneralStatistical');

    Route::post('/import-type-csv', [App\Http\Controllers\Admin\ImportCSVController::class, 'importTypeCsv'])->name('admin.import.importTypeCsv');
    Route::post('/import-description-csv', [App\Http\Controllers\Admin\ImportCSVController::class, 'importDescriptionCsv'])->name('admin.import.importDescriptionCsv');
    Route::post('/import-product-csv', [App\Http\Controllers\Admin\ImportCSVController::class, 'importProductCsv'])->name('admin.import.importProductCsv');

    Route::get('/invoice-statistical', [App\Http\Controllers\Admin\StatisticalController::class, 'invoiceStatistical'])->name('admin.statistical.invoice');
    Route::get('/get-invoice-statistical', [App\Http\Controllers\Admin\StatisticalController::class, 'getInvoiceStatistical'])->name('admin.statistical.getInvoiceStatistical');
    Route::post('/get-profit-table', [App\Http\Controllers\Admin\StatisticalController::class, 'getProfitTable'])->name('admin.statistical.getProfitTable'); //trả dữ liệu ra form list

    Route::get('/product-statistical', [App\Http\Controllers\Admin\StatisticalController::class, 'productStatistical'])->name('admin.statistical.product');
    Route::get('/get-product-statistical', [App\Http\Controllers\Admin\StatisticalController::class, 'getProductStatistical'])->name('admin.statistical.getProductStatistical');

    Route::get('/rating-statistical', [App\Http\Controllers\Admin\StatisticalController::class, 'ratingStatistical'])->name('admin.statistical.rating');
    Route::get('/get-rating-statistical', [App\Http\Controllers\Admin\StatisticalController::class, 'getRatingStatistical'])->name('admin.statistical.getRatingStatistical');

    //Post //edit ngay trên trang //add kiểu modal
    Route::get('/post', [App\Http\Controllers\Admin\PostController::class, 'index'])->name('admin.post.list'); //gọi form list
    Route::post('/get-post', [App\Http\Controllers\Admin\PostController::class, 'getData'])->name('admin.post.getData'); //trả dữ liệu ra form list
    Route::get('/fill-post', [App\Http\Controllers\Admin\PostController::class, 'create'])->name('admin.post.create');
    Route::post('/update-post-status/{id}', [App\Http\Controllers\Admin\PostController::class, 'updatePostStatus'])->name('admin.post.updatePostStatus'); //trả dữ liệu ra form list
    Route::post('/post-add', [\App\Http\Controllers\Admin\PostController::class, 'store'])->name('admin.post.store'); //Thêm
    Route::post('/post/{id}/update', [App\Http\Controllers\Admin\PostController::class, 'update'])->name('admin.post.update'); //Sửa
    Route::get('/post/{id}/delete', [App\Http\Controllers\Admin\PostController::class, 'destroy'])->name('admin.post.delete'); //Xóa

    //Type //edit gọi ra trang thứ 2 //add trang thứ 2
    Route::get('/type', [App\Http\Controllers\Admin\TypeController::class, 'index'])->name('admin.type.list'); //gọi form list
    Route::get('/get-type', [App\Http\Controllers\Admin\TypeController::class, 'getData'])->name('admin.type.getData'); //trả dữ liệu ra form list
    Route::get('/type/add', [App\Http\Controllers\Admin\TypeController::class, 'create'])->name('admin.type.create'); //thêm
    Route::post('/type/type-add', [App\Http\Controllers\Admin\TypeController::class, 'store'])->name('admin.type.store'); //thêm
    Route::get('/type/{id}/edit', [App\Http\Controllers\Admin\TypeController::class, 'edit'])->name('admin.type.edit'); //gọi trang edit
    Route::post('/type/{id}/type-update', [App\Http\Controllers\Admin\TypeController::class, 'update'])->name('admin.type.update'); //trả dữ liệu ra form list
    Route::get('/type/{id}/delete', [App\Http\Controllers\Admin\TypeController::class, 'destroy'])->name('admin.type.delete'); //Xóa
    Route::post('type/delete-all', [App\Http\Controllers\Admin\TypeController::class, 'deleteAll'])->name('admin.type.deleteAll'); //Xóa

    //Coupon //edit gọi ra trang thứ 2 //add trang thứ 2
    Route::get('/coupon', [App\Http\Controllers\Admin\CouponController::class, 'index'])->name('admin.coupon.list'); //gọi form list
    Route::get('/get-coupon', [App\Http\Controllers\Admin\CouponController::class, 'getData'])->name('admin.coupon.getData'); //trả dữ liệu ra form list
    Route::post('/update-coupon-status/{id}', [App\Http\Controllers\Admin\CouponController::class, 'updateCouponStatus'])->name('admin.product.updateCouponStatus');
    Route::get('/coupon/addForSendMail', [App\Http\Controllers\Admin\CouponController::class, 'addForSendMail'])->name('admin.coupon.addForSendMail'); //Thêm để gửi qua mail cho khách
    Route::get('/coupon/addForShowCustomer', [App\Http\Controllers\Admin\CouponController::class, 'addForShowCustomer'])->name('admin.coupon.addForShowCustomer'); //Thêm để show ra màn hình cho khách

    Route::post('/coupon/coupon-send', [App\Http\Controllers\Admin\CouponController::class, 'couponSend'])->name('admin.coupon.couponSend'); //thêm
    Route::post('/coupon/coupon-show', [App\Http\Controllers\Admin\CouponController::class, 'couponShow'])->name('admin.coupon.couponShow'); //thêm
    Route::get('/coupon/{id}/edit', [App\Http\Controllers\Admin\CouponController::class, 'edit'])->name('admin.coupon.edit'); //gọi trang edit
    Route::post('/coupon/{id}/coupon-update', [App\Http\Controllers\Admin\CouponController::class, 'update'])->name('admin.coupon.update'); //trả dữ liệu ra form list
    Route::get('/coupon/{id}/delete', [App\Http\Controllers\Admin\CouponController::class, 'destroy'])->name('admin.coupon.delete'); //Xóa
    Route::get('/coupon/{id}/send-customer', [App\Http\Controllers\Admin\CouponController::class, 'sendCustomer'])->name('admin.coupon.sendCustomer'); //gửi mã cho khách hàng
    Route::get('/coupon/{id}/view-customer', [App\Http\Controllers\Admin\CouponController::class, 'viewCustomer'])->name('admin.coupon.viewCustomer'); //show mã cho khách hàng

    //Weight //view kiểu datatable //edit gọi ra trang thứ 2  //add trang thứ 2
    Route::get('/weight', [App\Http\Controllers\Admin\WeightController::class, 'index'])->name('admin.weight.list'); //gọi form list
    Route::get('/get-weight', [App\Http\Controllers\Admin\WeightController::class, 'getData'])->name('admin.weight.getData'); //trả dữ liệu ra form list
    Route::match(['get', 'post'], '/weight-add', [App\Http\Controllers\Admin\WeightController::class, 'weightAdd'])->name('admin.weight.create'); //thêm
    Route::get('/weight/{id}/edit', [App\Http\Controllers\Admin\WeightController::class, 'edit'])->name('admin.weight.edit'); //gọi trang edit
    Route::post('/weight/{id}/weight-update', [App\Http\Controllers\Admin\WeightController::class, 'update'])->name('admin.weight.update'); //trả dữ liệu ra form list
    Route::get('/weight/{id}/delete', [App\Http\Controllers\Admin\WeightController::class, 'destroy'])->name('admin.weight.delete'); //Xóa

    //Product //edit kiểu modal  //add kiểu modal
    Route::get('/product', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.product.list'); //gọi form list
    Route::get('/get-product', [App\Http\Controllers\Admin\ProductController::class, 'getData'])->name('admin.product.getData'); //trả dữ liệu ra form list
    Route::get('/fill-product', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.product.create');
    Route::post('/update-product-status/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update_product_status'])->name('admin.product.updateStatus'); //trả dữ liệu ra form list
    Route::post('/product/update', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.product.update'); //Sửa
    Route::get('/product/{id}/delete', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.product.delete'); //Xóa

    // Route::get('/product-image', [App\Http\Controllers\Admin\ProductController::class, 'productImage'])->name('admin.productImage.list'); //Sửa
    // Route::get('/get-product-image', [App\Http\Controllers\Admin\ProductController::class, 'getProductImage'])->name('admin.product.getProductImage'); //trả dữ liệu ra form list

    //Thêm Ảnh
    Route::get('/add-image/{id}', [App\Http\Controllers\Admin\ProductController::class, 'addProductImage'])->name('admin.productImage.AddProductImage'); //Sửa
    Route::get('/detail-image/{id}', [App\Http\Controllers\Admin\ProductController::class, 'detailProductImage'])->name('admin.productImage.detailProductImage'); //Sửa
    Route::get('/edit-image/{id}', [App\Http\Controllers\Admin\ProductController::class, 'editProductImage'])->name('admin.productImage.editProductImage'); //Sửa
    Route::post('/update-image/{id}', [App\Http\Controllers\Admin\ProductController::class, 'updateProductImage'])->name('admin.productImage.updateProductImage'); //Sửa

    Route::post('/product-image/save', [App\Http\Controllers\Admin\ProductController::class, 'saveProductImage'])->name('admin.productImage.saveProductImage'); //Sửa
    //Thêm Ảnh

    // Route::get('/detail-image/{id}/edit', [App\Http\Controllers\Admin\ProductController::class, 'detailProductImage'])->name('admin.productImage.detailProductImage'); //Sửa
    Route::get('/detail-image/{id}/get-image', [App\Http\Controllers\Admin\ProductController::class, 'getDetailProductImage'])->name('admin.productImage.getDetailProductImage'); //Sửa

    Route::get('/description', [App\Http\Controllers\Admin\DescriptionController::class, 'index'])->name('admin.description.list'); //gọi form list
    Route::get('/get-description', [App\Http\Controllers\Admin\DescriptionController::class, 'getData'])->name('admin.description.getData'); //trả dữ liệu ra form list
    Route::get('/description/add', [App\Http\Controllers\Admin\DescriptionController::class, 'create'])->name('admin.description.create'); //thêm
    Route::post('/description/description-add', [App\Http\Controllers\Admin\DescriptionController::class, 'store'])->name('admin.description.store'); //thêm
    Route::get('/description/{id}/edit', [App\Http\Controllers\Admin\DescriptionController::class, 'edit'])->name('admin.description.edit'); //gọi trang edit
    Route::post('/description/{id}/description-update', [App\Http\Controllers\Admin\DescriptionController::class, 'update'])->name('admin.description.update'); //trả dữ liệu ra form list
    Route::get('/description/{id}/delete', [App\Http\Controllers\Admin\DescriptionController::class, 'destroy'])->name('admin.description.delete'); //Xóa
    Route::post('description/delete-all', [App\Http\Controllers\Admin\DescriptionController::class, 'deleteAll'])->name('admin.description.deleteAll'); //Xóa

    //categorypost //edit gọi ra trang thứ 2 //add trang thứ 2
    Route::get('/category-post', [App\Http\Controllers\Admin\CategoryPostController::class, 'index'])->name('admin.categorypost.list'); //gọi form list
    Route::get('/get-category-post', [App\Http\Controllers\Admin\CategoryPostController::class, 'getData'])->name('admin.categorypost.getData'); //trả dữ liệu ra form list
    Route::get('/category-post/add', [App\Http\Controllers\Admin\CategoryPostController::class, 'create'])->name('admin.categorypost.create'); //thêm
    Route::post('/category-post/category-post-add', [App\Http\Controllers\Admin\CategoryPostController::class, 'store'])->name('admin.categorypost.store'); //thêm
    Route::get('/category-post/{id}/edit', [App\Http\Controllers\Admin\CategoryPostController::class, 'edit'])->name('admin.categorypost.edit'); //gọi trang edit
    Route::post('/category-post/{id}/category-post-update', [App\Http\Controllers\Admin\CategoryPostController::class, 'update'])->name('admin.categorypost.update'); //trả dữ liệu ra form list
    Route::get('/category-post/{id}/delete', [App\Http\Controllers\Admin\CategoryPostController::class, 'destroy'])->name('admin.categorypost.delete'); //Xóa

    //Order //edit gọi ra trang thứ 2 //add trang thứ 2
    Route::get('/order', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.order.list'); //gọi form list
    Route::get('/get-order', [App\Http\Controllers\Admin\OrderController::class, 'getData'])->name('admin.order.getData'); //trả dữ liệu ra form list
    Route::get('/order/{id}/detail', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.order.detail'); //gọi trang edit
    Route::post('/update-order-status', [App\Http\Controllers\Admin\OrderController::class, 'updateOrderStatus'])->name('admin.order.updateOrderStatus'); //gọi trang edit
    Route::get('/print-order/{checkout_code}', [App\Http\Controllers\Admin\OrderController::class, 'printOrder'])->name('admin.order.printOrder');

    //Warehouse
    Route::get('/warehouse', [App\Http\Controllers\Admin\WareHouseController::class, 'index'])->name('admin.warehouse.list'); //gọi form list
    Route::get('/get-warehouse', [App\Http\Controllers\Admin\WareHouseController::class, 'getData'])->name('admin.warehouse.getData'); //trả dữ liệu ra form list
    Route::get('/warehouse/add', [App\Http\Controllers\Admin\WareHouseController::class, 'create'])->name('admin.warehouse.create'); //thêm
    Route::post('/warehouse/warehouse-add', [App\Http\Controllers\Admin\WareHouseController::class, 'store'])->name('admin.warehouse.store'); //thêm
    Route::get('/warehouse/{id}/edit', [App\Http\Controllers\Admin\WareHouseController::class, 'edit'])->name('admin.warehouse.edit'); //gọi trang edit
    Route::post('/warehouse/{id}/warehouse-update', [App\Http\Controllers\Admin\WareHouseController::class, 'update'])->name('admin.warehouse.update');
    Route::post('/warehouse/excel-import-image', [App\Http\Controllers\Admin\WareHouseController::class, 'excelImportImage'])->name('admin.warehouse.excelImportImage'); //thêm ảnh khi import excel

    //User
    Route::get('/user', [App\Http\Controllers\Admin\User\AccountController::class, 'index'])->name('admin.user.list'); //gọi form list
    Route::get('/get-user', [App\Http\Controllers\Admin\User\AccountController::class, 'getUser'])->name('admin.user.getUser'); //trả dữ liệu ra form list
    Route::get('/user/{id}/delete', [App\Http\Controllers\Admin\User\AccountController::class, 'deleteUser'])->name('admin.user.deleteUser'); //trả dữ liệu ra form list
    Route::get('/account/{id}/detail', [App\Http\Controllers\Admin\User\AccountController::class, 'showViewUser'])->name('admin.user.showViewUser'); //gọi trang edit
    Route::get('/account/{id}/get-user-detail', [App\Http\Controllers\Admin\User\AccountController::class, 'getUserDetail'])->name('admin.user.getUserDetail'); //trả dữ liệu ra form list

    Route::get('/shipper', [App\Http\Controllers\Admin\User\ShipperController::class, 'indexShip'])->name('admin.shipper.list'); //gọi form list
    Route::get('/get-ship', [App\Http\Controllers\Admin\User\ShipperController::class, 'getShipper'])->name('admin.shipper.getShipper'); //trả dữ liệu ra form list
    Route::post('/ship-add', [App\Http\Controllers\Admin\User\ShipperController::class, 'store'])->name('admin.shipper.add'); //thêm
    Route::post('/ship/{id}/update', [App\Http\Controllers\Admin\User\ShipperController::class, 'update'])->name('admin.shipper.update'); //Sửa
    Route::get('/ship/{id}/delete', [App\Http\Controllers\Admin\User\ShipperController::class, 'destroy'])->name('admin.shipper.delete'); //Xóa

    Route::get('/adminer', [App\Http\Controllers\Admin\User\AdminController::class, 'index'])->name('admin.admin.list'); //gọi form list
    Route::get('/get-admin', [App\Http\Controllers\Admin\User\AdminController::class, 'getAdmin'])->name('admin.getShipper'); //trả dữ liệu ra form list
    Route::post('/admin-add', [App\Http\Controllers\Admin\User\AdminController::class, 'store'])->name('admin.add'); //thêm
    Route::post('/admin/{id}/update', [App\Http\Controllers\Admin\User\AdminController::class, 'update'])->name('admin.update'); //Sửa
    Route::get('/admin/{id}/delete', [App\Http\Controllers\Admin\User\AdminController::class, 'destroy'])->name('admin.delete'); //Xóa

    //ReplyComment
    Route::get('/replyComment', [App\Http\Controllers\Admin\ReplyCommentController::class, 'index'])->name('admin.replyComment.list'); //gọi form list
    Route::get('/get-replyComment', [App\Http\Controllers\Admin\ReplyCommentController::class, 'getData'])->name('admin.replyComment.getData'); //trả dữ liệu ra form list
    Route::post('/single-send', [App\Http\Controllers\Admin\ReplyCommentController::class, 'singleSend'])->name('admin.replyComment.singleSend');
    Route::post('/all-send', [App\Http\Controllers\Admin\ReplyCommentController::class, 'allSend'])->name('admin.replyComment.allSend');
});

Route::get('/', [App\Http\Controllers\Sale\HomeController::class, 'index'])->name('sale.index');
Route::get('/404', [App\Http\Controllers\Sale\HomeController::class, 'error404'])->name('sale.error404');
Route::get('/500', [App\Http\Controllers\Sale\HomeController::class, 'error500'])->name('sale.error500');
Route::get('/shop', [App\Http\Controllers\Sale\ShopController::class, 'index'])->name('sale.shop.index');
Route::get('/blog', [App\Http\Controllers\Sale\PostController::class, 'index'])->name('sale.post.index');
Route::get('/get-post-list', [App\Http\Controllers\Sale\PostController::class, 'getData'])->name('sale.post.getData');
Route::get('blog/{id}/detail', [App\Http\Controllers\Sale\PostController::class, 'viewDetail'])->name('sale.post.viewDetail');
Route::get('blog/{id}/get-detail', [App\Http\Controllers\Sale\PostController::class, 'getDetail'])->name('sale.post.getDetail');
Route::get('/contact', [App\Http\Controllers\Sale\ContactController::class, 'index'])->name('sale.contact.index');

Route::post('/quick-view-shop', [App\Http\Controllers\Sale\HomeController::class, 'quickViewShop'])->name('sale.quickViewShop');

Route::get('/get-product-shop', [App\Http\Controllers\Sale\ShopController::class, 'getData'])->name('admin.shop.getData'); //trả dữ liệu ra form list
Route::get('/product-detail/{id}', [App\Http\Controllers\Sale\ShopController::class, 'productDetail'])->name('admin.shop.productDetail'); //gọi trang detail product
Route::get('/get-related-product/{id}', [App\Http\Controllers\Sale\ShopController::class, 'productRelated'])->name('admin.shop.productRelated');
Route::get('/get-compare-product/{id}', [App\Http\Controllers\Sale\ShopController::class, 'productCompare'])->name('admin.shop.productCompare');
Route::post('/fill-evaluated/{id}', [App\Http\Controllers\Sale\ShopController::class, 'fillEvaluated'])->name('admin.shop.fillEvaluated');

Route::post('/choose-weight-product', [App\Http\Controllers\Sale\ShopController::class, 'chooseWeightProduct'])->name('admin.shop.chooseWeightProduct');
Route::post('/fill-weight-product/{id}', [App\Http\Controllers\Sale\ShopController::class, 'fillWeightProduct'])->name('admin.shop.fillWeightProduct');

Route::get('/get-accessory/{id}', [App\Http\Controllers\Sale\ShopController::class, 'getAccessory'])->name('admin.shop.getAccessory');
Route::get('/get-coupon-store', [App\Http\Controllers\Sale\ShopController::class, 'getCouponStore'])->name('admin.shop.getCouponStore');

//show đánh giá ra chi tiết sp
Route::post('/get-evaluated', [App\Http\Controllers\Sale\CustomerReviewController::class, 'getEvaluated'])->name('sale.evaluate.getEvaluated');
Route::post('/get-select-5star', [App\Http\Controllers\Sale\CustomerReviewController::class, 'getSelect5Star'])->name('sale.evaluate.getSelect5Star');
Route::post('/get-select-4star', [App\Http\Controllers\Sale\CustomerReviewController::class, 'getSelect4Star'])->name('sale.evaluate.getSelect4Star');
Route::post('/get-select-3star', [App\Http\Controllers\Sale\CustomerReviewController::class, 'getSelect3Star'])->name('sale.evaluate.getSelect3Star');
Route::post('/get-select-2star', [App\Http\Controllers\Sale\CustomerReviewController::class, 'getSelect2Star'])->name('sale.evaluate.getSelect2Star');
Route::post('/get-select-1star', [App\Http\Controllers\Sale\CustomerReviewController::class, 'getSelect1Star'])->name('sale.evaluate.getSelect1Star');
Route::post('/get-select-haveimage', [App\Http\Controllers\Sale\CustomerReviewController::class, 'getSelectHaveImage'])->name('sale.evaluate.getSelectHaveImage');

Route::post('/get-count-star', [App\Http\Controllers\Sale\CustomerReviewController::class, 'getCountStar'])->name('sale.evaluate.getCountStar');

Route::get('/get-full-product', [App\Http\Controllers\Sale\SearchAllController::class, 'getFullProduct'])->name('admin.searchAll.getFullProduct');
Route::get('/search-product', [App\Http\Controllers\Sale\SearchAllController::class, 'searchProduct'])->name('admin.searchAll.getSearchProduct');
Route::post('/contact/add-exchange-review', [App\Http\Controllers\Sale\ExchangeReviewController::class, 'store'])->name('admin.comment.store'); //thêm comment
Route::get('/get-exchange-review', [App\Http\Controllers\Sale\ExchangeReviewController::class, 'getExchangeReview'])->name('admin.comment.getExchangeReview'); //Show data comment
Route::post('reply-exchange-review/{id}', [App\Http\Controllers\Sale\ExchangeReviewController::class, 'replyExchangeReview'])->name('admin.comment.replyComment'); //thêm comment
Route::get('/get-exchangeReviewReply/{id}', [App\Http\Controllers\Sale\ExchangeReviewController::class, 'getExchangeReviewReply'])->name('admin.comment.getExchangeReviewReply'); //Show data comment
Route::post('reply-exchange-review-second/{id}', [App\Http\Controllers\Sale\ExchangeReviewController::class, 'replyExchangeReviewSecond'])->name('admin.comment.replyCommentSecond'); //thêm comment
Route::post('/exchangeReview/delete', [App\Http\Controllers\Sale\ExchangeReviewController::class, 'exchangeReviewDelete'])->name('admin.comment.exchangeReviewDelete'); //Xóa
// Route::post('/fill-image', [App\Http\Controllers\Sale\ExchangeReviewController::class, 'fillImage'])->name('sale.users.fillImage');

Route::get('/choose-type/{id}', [App\Http\Controllers\Sale\ShopController::class, 'chooseType'])->name('admin.shop.chooseType'); //Show view type product
Route::get('/get-type-product/{id}', [App\Http\Controllers\Sale\ShopController::class, 'getTypeProduct'])->name('admin.shop.getTypeProduct'); //Show data type product
Route::get('/choose-description/{id}', [App\Http\Controllers\Sale\ShopController::class, 'chooseDescription'])->name('admin.shop.chooseDescription'); //Show view type product
Route::get('/get-description-product/{id}', [App\Http\Controllers\Sale\ShopController::class, 'getDescriptionProduct'])->name('admin.shop.getDescriptionProduct'); //Show data type product
Route::get('/choose-weight/{id}', [App\Http\Controllers\Sale\ShopController::class, 'chooseWeight'])->name('admin.shop.chooseWeight'); //Show view weight product
Route::get('/get-weight-product/{id}', [App\Http\Controllers\Sale\ShopController::class, 'getWeightProduct'])->name('admin.shop.getWeightProduct'); //Show data weight product

Route::post('/add-to-cart', [App\Http\Controllers\Sale\CartController::class, 'addCart'])->name('admin.cart.addCart'); //thêm
Route::get('/del-product-cart/{session_id}', [App\Http\Controllers\Sale\CartController::class, 'delProductCart'])->name('admin.cart.delProductCart'); //xóa cart
Route::get('/view-cart', [App\Http\Controllers\Sale\CartController::class, 'viewCart'])->name('admin.cart.viewCart'); //view cart
Route::get('/del-all-product', [App\Http\Controllers\Sale\CartController::class, 'delAllCart'])->name('admin.cart.delAllCart'); //xóa sp
Route::get('/unset-coupon', [App\Http\Controllers\Sale\CartController::class, 'unsetCoupon'])->name('admin.cart.unsetCoupon'); //xóa coupon
Route::post('/update-cart', [App\Http\Controllers\Sale\CartController::class, 'updateCart'])->name('admin.cart.updateCart'); //update giỏ
Route::post('/check-coupon', [App\Http\Controllers\Sale\CartController::class, 'checkCoupon'])->name('admin.cart.checkCoupon'); //update giỏ

Route::post('/add-product-accessories', [App\Http\Controllers\Sale\CartController::class, 'addProductAccessories'])->name('admin.cart.addProductAccessories'); //thêm
Route::post('/add-to-favorite', [App\Http\Controllers\Sale\FavoriteProductController::class, 'addFavorite'])->name('admin.cart.addCart'); //thêm sp yêu thích
Route::get('/del-favorite-product/{session_id}', [App\Http\Controllers\Sale\FavoriteProductController::class, 'delProductFavorite'])->name('admin.cart.delProductFavorite'); //thêm sp yêu thích
Route::get('/del-viewed-product/{session_id}', [App\Http\Controllers\Sale\ShopController::class, 'delViewedProduct'])->name('admin.viewd.delViewedProduct'); //thêm sp yêu thích
Route::get('/register-confirm/{email}', [App\Http\Controllers\Sale\User\AccountController::class, 'registerConfirm'])->name('sale.users.registerConfirm');

Route::match(['get', 'post'], '/login', [App\Http\Controllers\Sale\User\AccountController::class, 'loginForm'])->name('sale.users.login');
Route::get('/register-form', [App\Http\Controllers\Sale\User\AccountController::class, 'registerForm'])->name('sale.users.registerForm');
Route::post('/register', [App\Http\Controllers\Sale\User\AccountController::class, 'register'])->name('sale.users.register');
Route::match(['get', 'post'], '/sale/forgot-password', [App\Http\Controllers\Sale\User\Password\PasswordController::class, 'passwordForm'])->name('sale.users.forgot');
Route::get('sale/forgot-password-complete', [App\Http\Controllers\Sale\User\Password\PasswordController::class, 'forgotPasswordComplete'])->name('sale.users.forgotPasswordComplete');
Route::get('sale/reset-password/{email}/{token}', [App\Http\Controllers\Sale\User\Password\PasswordController::class, 'getToken'])->name('sale.users.getToken');
Route::post('sale/resetPassword', [App\Http\Controllers\Sale\User\Password\PasswordController::class, 'resetPassword'])->name('sale.users.resetPassword');
Route::get('/sale/change-password-complete', [App\Http\Controllers\Sale\User\Password\PasswordController::class, 'changePasswordComplete'])->name('sale.users.changePasswordComplete');

Route::middleware([Sale::class])->prefix('/sale')->group(function () {
    Route::get('/home', [App\Http\Controllers\Sale\HomeController::class, 'index'])->name('sale.home');
    Route::get('/logout', [App\Http\Controllers\Sale\User\AccountController::class, 'logout'])->name('sale.users.logout');
    Route::post('/order-place', [App\Http\Controllers\Sale\CheckoutController::class, 'checkOut'])->name('sale.checkout.checkOut'); //Chọn hình thức thanh toán
    Route::post('/checkout-cart', [App\Http\Controllers\Sale\CheckoutController::class, 'checkoutCart'])->name('admin.checkout.checkoutCart'); //thanh toán khi nhận tiền
    Route::post('/checkout-paypal', [App\Http\Controllers\Sale\CheckoutController::class, 'checkoutPaypal'])->name('admin.checkout.checkoutPaypal'); //thanh toán paypal
    Route::post('/checkout-vnpay', [App\Http\Controllers\Sale\CheckoutController::class, 'checkoutVnpay'])->name('admin.checkout.checkoutVnpay'); //thanh toán paypal
    Route::get('/success-vnpay', [App\Http\Controllers\Sale\CheckoutController::class, 'successPay'])->name('admin.checkout.successPay'); //thanh toán paypal

    Route::post('/checkout-onepay', [App\Http\Controllers\Sale\CheckoutController::class, 'checkoutOnepay'])->name('admin.checkout.checkoutOnepay'); //thanh toán paypal
    Route::post('/checkout-momo', [App\Http\Controllers\Sale\CheckoutController::class, 'checkoutMomo'])->name('admin.checkout.checkoutMomo'); //thanh toán paypal

    Route::get('/profile', [App\Http\Controllers\Sale\ProfileController::class, 'index'])->name('sale.profile.index');
    Route::get('/coupon', [App\Http\Controllers\Sale\CouponController::class, 'index'])->name('sale.coupon.index');
    Route::get('/get-user', [App\Http\Controllers\Sale\ProfileController::class, 'getUser'])->name('sale.profile.getUser');
    Route::get('/get-coupon', [App\Http\Controllers\Sale\CouponController::class, 'getCoupon'])->name('sale.coupon.getCoupon');
    Route::post('user-update', [App\Http\Controllers\Sale\ProfileController::class, 'updateUser'])->name('sale.profile.updateUser');

    Route::post('get-vote-product', [App\Http\Controllers\Sale\CustomerReviewController::class, 'getVoteProduct'])->name('sale.evaluate.getVoteProduct');
    Route::post('customer-reviews', [App\Http\Controllers\Sale\CustomerReviewController::class, 'customerReview'])->name('sale.evaluate.customerReview');
    Route::post('get-view-voted', [App\Http\Controllers\Sale\CustomerReviewController::class, 'getViewVoted'])->name('sale.evaluate.getViewVoted'); //Trả ra các sp chưa được voted
    Route::post('get-voted-product', [App\Http\Controllers\Sale\CustomerReviewController::class, 'getVotedProduct'])->name('sale.evaluate.getVotedProduct'); //Trả ra các sp đã được voted

    Route::post('get-order-confirm', [App\Http\Controllers\Sale\OrderWithStatusController::class, 'getOrderConfirm'])->name('sale.orderStatus.getOrderConfirm');
    Route::post('get-order-deliver', [App\Http\Controllers\Sale\OrderWithStatusController::class, 'getOrderDeliver'])->name('sale.orderStatus.getOrderDeliver');
    Route::post('get-order-receive', [App\Http\Controllers\Sale\OrderWithStatusController::class, 'getOrderReceive'])->name('sale.orderStatus.getOrderReceive');
    Route::post('get-order-evaluat', [App\Http\Controllers\Sale\OrderWithStatusController::class, 'getOrderEvaluat'])->name('sale.orderStatus.getOrderEvaluat');
    Route::post('get-order-cancel', [App\Http\Controllers\Sale\OrderWithStatusController::class, 'getOrderCancel'])->name('sale.orderStatus.getOrderCancel');
    Route::post('get-order-return', [App\Http\Controllers\Sale\OrderWithStatusController::class, 'getOrderReturn'])->name('sale.orderStatus.getOrderReturn');

    Route::post('/get-count-status', [App\Http\Controllers\Sale\OrderWithStatusController::class, 'getCountStatus'])->name('sale.orderStatus.getCountStatus');
    Route::post('/fill-image', [App\Http\Controllers\Sale\ExchangeReviewController::class, 'fillImage'])->name('sale.users.fillImage');
    Route::post('/save-coupon-store/{id}', [App\Http\Controllers\Sale\ShopController::class, 'saveCouponStore'])->name('admin.shop.saveCouponStore');
    Route::post('/get-coupon-user', [App\Http\Controllers\Sale\ShopController::class, 'getCouponUser'])->name('admin.shop.saveCouponStore');

    //manage order
    Route::get('/manage-order', [App\Http\Controllers\Sale\OrderController::class, 'manageOrder'])->name('sale.order.manageOrder'); //gọi trang order
    Route::get('/get-order', [App\Http\Controllers\Sale\OrderController::class, 'getData'])->name('sale.order.getData'); //lấy ra data
    Route::post('cancel-order', [App\Http\Controllers\Sale\OrderController::class, 'cancelOrder'])->name('sale.order.cancelOrder'); //Hủy đơn hàng
    Route::get('order/{id}/receivedOrder', [App\Http\Controllers\Sale\OrderController::class, 'receivedOrder'])->name('sale.order.receivedOrder'); //đã nhận hàng
    Route::get('order/{id}/repurchase', [App\Http\Controllers\Sale\OrderController::class, 'repurchase'])->name('sale.order.repurchase'); //mua lại
    Route::get('order-detail/{order_code}/view', [App\Http\Controllers\Sale\OrderController::class, 'orderDetail'])->name('sale.order.orderDetail'); //gọi trang chi tiết order
});

Route::match(['get', 'post'], 'ship/login', [App\Http\Controllers\Ship\User\AccountController::class, 'loginForm'])->name('ship.users.login');
Route::middleware([Ship::class])->prefix('/ship')->group(function () {
    Route::get('/home', [App\Http\Controllers\Ship\HomeController::class, 'index'])->name('ship.home');
    Route::get('/logout', [App\Http\Controllers\Ship\User\AccountController::class, 'logout'])->name('ship.users.logout');
    Route::get('/order-list', [App\Http\Controllers\Ship\OrderController::class, 'orderList'])->name('ship.order.list');
    Route::get('/get-order', [App\Http\Controllers\Ship\OrderController::class, 'getData'])->name('ship.order.getData'); //lấy ra data
    Route::get('order/{id}/delivered', [App\Http\Controllers\Ship\OrderController::class, 'delivered'])->name('ship.order.delivered'); //shipper đã giao
});
