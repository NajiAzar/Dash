<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Frontend\ProductsController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\WishlistController; 
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;  
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FeedbackController;
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

Route::view('/', 'welcome');
Auth::routes();

Route::get('/login/admin',  [App\Http\Controllers\Auth\LoginController::class,'showAdminLoginForm']);
Route::get('/login/customer',  [App\Http\Controllers\Auth\LoginController::class,'showCustomerLoginForm'])->name('login.customer');
Route::get('/login/writer', [App\Http\Controllers\Auth\LoginController::class,'showWriterLoginForm']);
Route::get('/register/customer', [App\Http\Controllers\Auth\RegisterController::class,'showCustomerRegisterForm'])->name('register.customer');
Route::get('/register/admin', [App\Http\Controllers\Auth\RegisterController::class,'showAdminRegisterForm']);
Route::get('/register/writer', [App\Http\Controllers\Auth\RegisterController::class,'showWriterRegisterForm']);

Route::post('/login/customer', [App\Http\Controllers\Auth\LoginController::class,'customerLogin'])->name('customerLogin');
Route::post('/login/admin', [App\Http\Controllers\Auth\LoginController::class,'adminLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class,'adminLogin']);
Route::post('/login/writer', [App\Http\Controllers\Auth\LoginController::class,'writerLogin']);
Route::post('/register/customer', [App\Http\Controllers\Auth\RegisterController::class,'createCustomer'])->name('create.customer');
Route::post('/register/admin', [App\Http\Controllers\Auth\RegisterController::class,'createAdmin']);
Route::post('/register/writer', [App\Http\Controllers\Auth\RegisterController::class,'createWriter']);
Route::post('/logoutcust', [App\Http\Controllers\Auth\LoginController::class, 'logoutcust'])->name('logoutcust');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::get('/profile/show', [ProfileController::class, 'viewProfile'])->name('profile.show');
Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.resetform');
Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'resets'])->name('password.reset');
Route::get('/password/resets/{key}/{token}', [App\Http\Controllers\Auth\CustomResetPasswordController::class, 'showResetForm'])->name('password.resetform');
Route::post('/password/resets', [App\Http\Controllers\Auth\CustomResetPasswordController::class, 'resets'])->name('password.reset');

Route::get('/reset-custemail', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetlinkForm'])->name('password.custemail');
Route::post('/password-emailsend', [App\Http\Controllers\Auth\CustomForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.emailsend');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::get('/admin/dashboard',  [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
Route::post('/profile/updatePassword', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
Route::get('/admin/showform', [App\Http\Controllers\AdminController::class, 'showform'])->name('admin.showform');
Route::post('/admin/create', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.create');
Route::get('/admin/showadmin',[App\Http\Controllers\AdminController::class, 'showadmin'])->name('showadmin');
Route::get('/admin/edit/{id}', [App\Http\Controllers\AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/update/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
//Route::post('/admin/updatePassword', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');
Route::delete('/admin/delete/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.destroy');
Route::get('/testimonials/add', [App\Http\Controllers\TestimonialController::class, 'add'])->name('testimonials.add');
Route::post('/testimonial/store', [App\Http\Controllers\TestimonialController::class, 'store'])->name('testimonials.store');
Route::get('/testimonials/show', [App\Http\Controllers\TestimonialController::class, 'show'])->name('testimonials.show');
Route::get('/testimonials/edit/{id}', [App\Http\Controllers\TestimonialController::class, 'edit'])->name('testimonials.edit');
Route::put('/testimonials/{id}', [App\Http\Controllers\TestimonialController::class, 'update'])->name('testimonials.update');
Route::delete('/testimonials/{id}', [App\Http\Controllers\TestimonialController::class, 'destroy'])->name('testimonials.destroy');

Route::get('/homesliders/add', [App\Http\Controllers\HomeSlideController::class, 'add'])->name('homesliders.add');
Route::post('/homesliders/store', [App\Http\Controllers\HomeSlideController::class, 'store'])->name('homesliders.store');
Route::get('/homesliders/show', [App\Http\Controllers\HomeSlideController::class, 'show'])->name('homesliders.show');
Route::get('/homesliders/edit/{id}', [App\Http\Controllers\HomeSlideController::class, 'edit'])->name('homesliders.edit');
Route::put('/homesliders/{id}', [App\Http\Controllers\HomeSlideController::class, 'update'])->name('homesliders.update');
Route::delete('/homesliders/{id}', [App\Http\Controllers\HomeSlideController::class, 'destroy'])->name('homesliders.destroy');

Route::get('/promotionalbanners/add', [App\Http\Controllers\PromotionalBannerController::class, 'add'])->name('promotionalbanners.add');
Route::post('/promotionalbanners/store', [App\Http\Controllers\PromotionalBannerController::class, 'store'])->name('promotionalbanners.store');
Route::get('/promotionalbanners/show', [App\Http\Controllers\PromotionalBannerController::class, 'show'])->name('promotionalbanners.show');
Route::get('/promotionalbanners/edit/{id}', [App\Http\Controllers\PromotionalBannerController::class, 'edit'])->name('promotionalbanners.edit');
Route::put('/promotionalbanners/{id}', [App\Http\Controllers\PromotionalBannerController::class, 'update'])->name('promotionalbanners.update');
Route::delete('/promotionalbanners/{id}', [App\Http\Controllers\PromotionalBannerController::class, 'destroy'])->name('promotionalbanners.destroy');
Route::get('/sales-report', [App\Http\Controllers\SalesReportController::class, 'index'])->name('sales.report');
Route::get('/cancelledorders-report', [App\Http\Controllers\CancelledorderReportController::class, 'index'])->name('cancelledorders.report');


Route::post('/categories/toggle-featured', [App\Http\Controllers\CategoryController::class, 'toggleFeatured'])->name('categories.toggleFeatured');

Route::get('/categories/add', [App\Http\Controllers\CategoryController::class, 'add'])->name('categories.add');
Route::post('/categories/store', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/show', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [App\Http\Controllers\CategoryController::class,'update'])->name('categories.update');
Route::get('/categories/delete/{id}', [App\Http\Controllers\CategoryController::class, 'delete'])->name('categories.delete');
Route::get('/brands', [App\Http\Controllers\BrandController::class, 'index'])->name('brands.index');
Route::get('/brands/add', [App\Http\Controllers\BrandController::class, 'add'])->name('brands.add');
Route::post('/brands', [App\Http\Controllers\BrandController::class, 'store'])->name('brands.store');
Route::get('/brands/{brand}/edit', [App\Http\Controllers\BrandController::class, 'edit'])->name('brands.edit');
Route::put('/brands/{brand}', [App\Http\Controllers\BrandController::class, 'update'])->name('brands.update');
Route::delete('/brands/{brand}', [App\Http\Controllers\BrandController::class, 'destroy'])->name('brands.destroy');
Route::get('/products/add', [App\Http\Controllers\ProductController::class, 'add'])->name('products.add');
Route::post('/products/store', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
Route::get('/products/show', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/products/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/update/{id}', [App\Http\Controllers\ProductController::class,'update'])->name('products.update');
Route::delete('/products/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/view/{id}', [App\Http\Controllers\ProductController::class, 'view'])->name('products.view');

Route::get('/products/{id}', [App\Http\Controllers\Frontend\ProductsController::class, 'show'])->name('frontend.products.product_detail');




//Route::get('/products', [App\Http\Controllers\Frontend\ProductsController::class, 'index'])->name('frontend.products.index');
Route::get('/', [App\Http\Controllers\FrontendController::class, 'home'])->name('frontend.home');

Route::get('/products', [App\Http\Controllers\Frontend\ProductsController::class, 'index'])->name('frontend.products.index');
Route::get('/search', [App\Http\Controllers\Frontend\ProductsController::class, 'search'])->name('search');

Route::get('/products/filterByPrice', [App\Http\Controllers\Frontend\ProductsController::class, 'filterByPrice'])->name('frontend.products.filterByPrice');
// routes/web.php

Route::post('/cart/add/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::get('/cart',[App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/remove-from-cart/{product_id}', [App\Http\Controllers\CartController::class,'removeFromCart'])->name('cart.remove');


Route::post('/wishlist/add/{product}', [App\Http\Controllers\WishlistController::class,'add'])->name('wishlist.add');
Route::get('/wishlist', [App\Http\Controllers\WishlistController::class,'index'])->name('wishlist.index');
Route::delete('/wishlist/{wishlist}', [App\Http\Controllers\WishlistController::class,'remove'])->name('wishlist.remove');
//Route::post('/remove-from-cart/{productId}', [App\Http\Controllers\CartController::class,'removeFromCart'])->name('remove-from-cart');
Route::post('/cart/remove/{product_id}', [App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update-quantity', [App\Http\Controllers\CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::post('/cart/update-quantity-logged-out', [App\Http\Controllers\CartController::class, 'updateQuantityLoggedOut'])
    ->name('cart.updateQuantityLoggedOut');
// Display the checkout form
Route::view('/order-failure', 'order-failure')->name('order.failure');
Route::get('/checkout',  [App\Http\Controllers\CheckoutController::class, 'showCheckoutForm'])->name('checkout');
Route::post('/checkout',  [App\Http\Controllers\CheckoutController::class, 'processOrder'])->name('checkout.process');
Route::get('/thank-you/{orderId}', [App\Http\Controllers\CheckoutController::class, 'thankYouPage'])->name('thank-you-page');
Route::get('/edit-profile', [App\Http\Controllers\CustomerController::class, 'editProfile'])->name('editProfile');
Route::post('/update-profile', [App\Http\Controllers\CustomerController::class, 'updateProfile'])->name('updateProfile');
Route::get('/order-details', [App\Http\Controllers\CustomerController::class, 'orderDetails'])->name('orderDetails');
Route::get('/track-order/{orderId?}', [App\Http\Controllers\OrderController::class, 'trackOrder'])->name('trackOrder');
Route::get('/track-order', [App\Http\Controllers\OrderController::class, 'trackOrder'])->name('track');
// Route::get('/reorder/{orderId}', [App\Http\Controllers\CustomerController::class, 'reorder'])->name('reorder');
Route::get('/changepassword', [App\Http\Controllers\CustomerController::class, 'changepassword'])->name('changepassword');
Route::post('/update-password', [App\Http\Controllers\CustomerController::class, 'updatePassword'])->name('updatePassword');
Route::get('/orders/show', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
Route::get('/orders/view/{id}', [App\Http\Controllers\OrderController::class, 'view'])->name('orders.view');
Route::post('/orders/update-status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
Route::get('/orders/get-status/{order_id}', [App\Http\Controllers\OrderController::class, 'getStatus'])->name('orders.getStatus');
Route::put('/cancel-order/{orderId}', [App\Http\Controllers\OrderController::class, 'cancelOrder'])->name('cancelOrder');
Route::match(['post', 'put'], '/process-cancel-order/{orderId}', [App\Http\Controllers\OrderController::class, 'processCancelOrder'])->name('processCancelOrder');
Route::get('/verify-order/{orderId}',[App\Http\Controllers\OrderController::class, 'showVerificationPage'])->name('verifyOrderPage');
Route::match(['get', 'post', 'put'], '/verify-order-email/{orderId}', [App\Http\Controllers\OrderController::class, 'verifyOrderemail'])->name('verifyOrderemail');
Route::get('/cancel-verified-order/{orderId}',  [App\Http\Controllers\OrderController::class, 'cancelorderDetails'])->name('cancelorderDetails');
Route::get('/verified-order-details/{orderId}', [App\Http\Controllers\OrderController::class, 'showOrderDetails'])->name('VerifiedorderDetails');
Route::get('/orders/filter', [App\Http\Controllers\OrderController::class, 'filterOrders'])->name('orders.filter');
Route::get('/feedback/{order_number}', [App\Http\Controllers\OrderController::class, 'feedback'])->name('feedback');
Route::get('feedback/create/{orderNumber}', [App\Http\Controllers\FeedbackController::class, 'create'])->name('feedback.create');
Route::post('feedback/store/{orderNumber}', [App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');
Route::post('/razorpay/payment', [App\Http\Controllers\RazorpayController::class,'handlePaymentCallback']);
Route::post('/razorpay/payment/callback', [App\Http\Controllers\RazorpayController::class, 'handlePaymentCallback'])->name('razorpay.payment');
Route::post('/update-order-status/{orderId}/{transactionId}', [App\Http\Controllers\CheckoutController::class, 'updateStatus'])
    ->name('update-order-status');
Route::view('/home', 'home')->middleware('auth');
Route::view('/admin', 'admin');
Route::view('/writer', 'writer');
  



Auth::routes();



