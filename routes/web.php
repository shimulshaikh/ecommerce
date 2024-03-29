<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Category;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::prefix('/admin')->namespace('Admin')->group(function() {

	Route::match(['get','post'],'/', 'AdminController@login')->name('admin');

	Route::group(['middleware' => ['admin']], function(){

		Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
		Route::get('settings', 'AdminController@settings')->name('settings');
		Route::get('logout', 'AdminController@logout')->name('logout');	
		Route::post('check-current-pwd', 'AdminController@checkCurrentPwd');
		Route::post('update-current-pwd', 'AdminController@updateCurrentPwd')->name('updateCurrentPwd');
		Route::match(['get','post'],'update-admin-details', 'AdminController@updateAdminDetails')->name('updateAdminDetails');	

		//section route
		Route::resource('/section', SectionController::class); 
		Route::post('update-section-status', 'SectionController@updateSectionStatus');

		//Brand route
		Route::resource('/brand', BrandController::class); 
		Route::post('update-brand-status', 'BrandController@updateBrandStatus');
		Route::get('delete-brand/{id}', 'BrandController@destroy')->name('brand.destroy');

		//category route
		Route::resource('/category', CategoryController::class);
		Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
		Route::post('append-categories-level', 'CategoryController@appendCategoriesLevel');
		Route::get('delete-category-image/{id}', 'CategoryController@deleteCategoryImage')->name('deleteCategoryImage');
		Route::get('delete-category/{id}', 'CategoryController@destroy');

		//Product Route
		Route::resource('/product', ProductController::class); 
		Route::post('update-product-status', 'ProductController@updateProductStatus');
		Route::get('delete-product/{id}', 'ProductController@destroy')->name('product.destroy');

		//product Attributes route
		Route::match(['get','post'],'add-attributes/{id}', 'ProductController@addAttributes')->name('addAttributes');
		Route::post('edit-attributes/{id}','ProductController@editAttributes')->name('editAttributes');
		Route::post('update-attribute-status', 'ProductController@updateAttributeStatus');
		Route::get('delete-product-attribute/{id}', 'ProductController@destroyAttribute')->name('destroyAttribute');

		//Product multiple Image route
		Route::match(['get','post'],'add-image/{id}', 'ProductController@addImage')->name('addImage');
		Route::post('update-images-status', 'ProductController@updateimagesStatus');
		Route::get('delete-product-images/{id}', 'ProductController@destroyImage')->name('destroyImage');

		//Banners route
		Route::resource('/banner', BannersController::class); 
		Route::post('update-banner-status', 'BannersController@updateBannerStatus');
		Route::get('delete-banner/{id}', 'BannersController@destroy')->name('banner.destroy');

		//Coupons router
		Route::get('coupons', 'CouponsController@coupons')->name('coupons');
		Route::post('update-coupon-status', 'CouponsController@updateCouponStatus');
		Route::match(['get','post'],'add-edit-coupon/{id?}', 'CouponsController@addEditCoupon');
		Route::get('delete-coupon/{id}', 'CouponsController@destroyCoupon');

		//orders router
		Route::get('orders', 'OrdersController@orders')->name('orders');
		Route::get('orders/{id}', 'OrdersController@orderDetails');	
		Route::post('update-order-status', 'OrdersController@updateOrderStatus');
		Route::get('view-order-invoice/{id}', 'OrdersController@viewOrderInvoice');	
		Route::get('print-pdf-invoice/{id}', 'OrdersController@printPDFInvoice');

		//shipping charges
		Route::get('shipping-charges', 'ShippingController@index')->name('shipping-charges');
		Route::match(['get','post'],'edit-shipping-charges/{id}', 'ShippingController@editShipping');
		Route::post('update-shipping-status', 'ShippingController@updateShippingStatus');	

	});
	

});


Route::namespace('Front')->group(function(){
	//home router
	Route::get('/', 'IndexController@index');
	
	//Listing/categories router
	$catUrl = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
	// Route::get('/{url}', 'ProductsController@listing');

	//Get category url
	foreach ($catUrl as $url) {
		Route::get('/'.$url, 'ProductsController@listing');
	}
	//Product details route
	Route::get('/product/{id}','ProductsController@details');

	//get product Attribute price
	Route::post('/get-product-price','ProductsController@getProductPrice');

	//Add to cart route
	Route::post('/add-to-cart','ProductsController@addToCart');

	//shopping cart Route
	Route::get('/cart','ProductsController@cart');	

	//Update cart Item Quentity
	Route::post('/update-cart-item-qty','ProductsController@updateCartItemQty');

	//Delete cart Item
	Route::post('/delete-cart-item','ProductsController@deleteCartItem');

	//Login/Register page
	Route::get('/login-register','UsersController@loginRegister')->name('loginRegister');	

	//Login user
	Route::post('/login','UsersController@loginUser')->name('loginUser');	

	//Register user
	Route::post('/register','UsersController@registerUser')->name('register');

	//check email if already exists
	Route::match(['get','post'],'/check-email', 'UsersController@checkEmail');

	//User logout
	Route::get('/logout','UsersController@logoutUser')->name('logout');		

	//confirm account
	Route::match(['get','post'],'confirm/{code}', 'UsersController@confirmAccount');

	//Forgot password
	Route::match(['get','post'],'/forgot-password', 'UsersController@forgotPassword');

	Route::group(['middleware'=>['auth']],function(){

		//user account
		Route::match(['get','post'],'/account', 'UsersController@userAccount')->name('account');

		//Users Orders
		Route::get('/orders', 'OrdersController@orders');

		//user order details
		Route::get('/orders/{id}', 'OrdersController@orderDetails');

		//Check user Password
		Route::post('/check-user-current-pwd','UsersController@checkUserCurrentPassword');

		//Update user password
		Route::post('/update-user-password','UsersController@updateUserPassword');

		//Apply coupon
		Route::post('/apply-coupon','ProductsController@applyCoupon');

		//checkout
		Route::match(['get','post'],'/checkout', 'ProductsController@checkout');

		//Add/edit/delivery/address
		Route::match(['get','post'],'/add-edit-delivery-address/{id?}', 'ProductsController@addEditDeliveryAddress');

		//Delete delivery address
		Route::get('/delete-delivery-address/{id?}', 'ProductsController@deleteDeliveryAddress');

		//For Thanks 
		Route::get('/thanks', 'ProductsController@thanks');

	});


});
