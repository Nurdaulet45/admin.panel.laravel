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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/** Admin side*/

Route::group(['middleware' => ['status', 'auth']], function () {
    $groupData = [
        'namespace' => 'Blog\Admin',
        'prefix' => 'admin',
    ];

    Route::group($groupData, function() {
        Route::resource('index', 'MainController')
            ->names('blog.admin.index');

        Route::resource('orders', 'OrderController')
            ->names('blog.admin.orders');
        Route::get('/orders/change/{id}', 'OrderController@change')
            ->name('blog.admin.orders.change');
        Route::post('/orders/save/{id}', 'OrderController@save')
            ->name('blog.admin.orders.save');
        Route::get('/orders/forcedestroy/{id}', 'OrderController@forcedestroy')
            ->name('blog.admin.orders.forcedestroy');

        Route::get("/categories/mydel",'CategoryController@mydel')
            ->name('blog.admin.categories.mydel');
        Route::resource('categories', 'CategoryController')
            ->names('blog.admin.categories');

        Route::resource('users', 'UserController')
            ->names('blog.admin.users');

        // для script_related_prod.blade
        Route::get('/products/related', 'ProductController@related');
        Route::match(['get', 'post'], '/products/ajax-image-upload', 'ProductController@ajaxImage');
        Route::delete('/products/ajax-remove-image/{filename}', 'ProductController@deleteImage');

        Route::post('/products/gallery', 'ProductController@gallery')
            ->name('blog.admin.products.gallery');
        Route::post('/product/delete-gallery', 'ProductController@deleteGallery')
            ->name('blog.admin.products.deletegallery');

        Route::get('/products/return-status/{id}', 'ProductController@returnStatus')
            ->name('blog.admin.products.returnstatus');
        Route::get('/product/delete-status/{id}', 'ProductController@deleteStatus')
            ->name('blog.admin.products.deletestatus');
        Route::get('/products/delete-product/{id}', 'ProductController@deleteProduct')
            ->name('blog.admin.products.deleteproduct');


        /** Filter*/
        Route::get('/filter/group-filter', 'FilterController@attributeGroup')
            ->name('blog.admin.filter.group-filter');
        Route::match(['get', 'post'], '/filter/group-add-group', 'FilterController@groupAdd');
        Route::match(['POST', 'GET'], '/filter/group-edit/{id}', 'FilterController@groupEdit')
            ->name('blog.admin.filter.group-edit');
        Route::get('/filter/group-delete/{id}', 'FilterController@groupDelete');

        Route::get('/filter/attributes-filter', 'FilterController@attributeFilter');
        Route::match(['POST', 'GET'], '/filter/attr-add', 'FilterController@attributeAdd');
        Route::match(['POST', 'GET'], '/filter/attr-edit/{id}', 'FilterController@attributeEdit');
        Route::get('/filter/attr-delete/{id}', 'FilterController@attributeDelete');


        /** Currency */
        Route::get('/currency/index', 'CurrencyController@index');
        Route::match(['get', 'post'], 'currency/add', 'CurrencyController@addCurrency');
        Route::match(['get', 'post'], 'currency/edit/{id}', 'CurrencyController@editCurrency');
        Route::get('/currency/delete/{id}', 'CurrencyController@deleteCurrency');

        Route::get('/search/result', 'SearchController@index');
        Route::get('/autocomplete', 'SearchController@search');



        Route::resource('product', 'ProductController')
            ->names('blog.admin.products');





    });

});

Route::get('user/index', 'Blog\User\MainController@index');



