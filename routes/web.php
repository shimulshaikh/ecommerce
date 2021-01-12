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
		Route::get('delete-category/{id}', 'CategoryController@destroy')->name('category.destroy');

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
	Route::get('/login-register','UsersController@loginRegister');	

	//Login user
	Route::post('/login','UsersController@loginUser');	

	//Register user
	Route::post('/register','UsersController@registerUser')->name('register');

	//User logout
	Route::get('/logout','UsersController@logoutUser')->name('logout');	
	
	//user Account
	Route::get('/my-account','UsersController@userAccount')->name('account');	
});
