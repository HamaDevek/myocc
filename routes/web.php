<?php


/* Dashboard Routes */


Route::get('/dashboard', 'Settings\AuthController@index')->name('login.index');
Route::post('/dashboard', 'Settings\AuthController@check')->name('login.check');
Route::get('/dashboard/logout', 'Settings\AuthController@logout')->name('login.logoutadmin');
Route::group([
    'middleware' => ['login'],
    'as' => 'dashboard.'
], function () {
    Route::get('/settings/index', 'Settings\IndexDashboardController@index')->name('dashboard.index');



    Route::resource('/settings/user/management', 'Settings\UserManagmentController');
    Route::resource('/settings/location', 'Settings\LocationController')->except(['update']);
    Route::put('/settings/location/{id}/{type}', 'Settings\LocationController@update')->name('location.update')->where(['id' => '[0-9]+', 'type' => '[1|0]']);
    Route::resource('/settings/type', 'Settings\TypeItemController')->except(['update'])->middleware('closed');
    Route::put('/settings/type/{id}/{type}', 'Settings\TypeItemController@update')->name('type.update')->where(['id' => '[0-9]+', 'type' => '[1|0]'])->middleware('closed');
    Route::resource('/settings/shop', 'Settings\ShopController')->except(['update']);
    Route::put('/settings/shop/{id}/{type}', 'Settings\ShopController@update')->name('shop.update')->where(['id' => '[0-9]+', 'type' => '[1|0]']);
    Route::resource('/settings/user', 'Settings\AdminController')->except(['update']);
    Route::put('/settings/user/{id}/{type}', 'Settings\AdminController@update')->name('user.update')->where(['id' => '[0-9]+', 'type' => '[1|0|2]']);
    Route::resource('/settings/item', 'Settings\ItemController')->except(['update']);
    Route::put('/settings/item/{id}/{type}', 'Settings\ItemController@update')->name('item.update')->where(['id' => '[0-9]+', 'type' => '[1|0|2]']);
    Route::post('/settings/item/color/{id}', 'Settings\ItemController@item_color')->name('item.color')->where(['id' => '[0-9]+']);
    Route::delete('/settings/item/color/{id}', 'Settings\ItemController@item_color_delete')->name('item.color_delete')->where(['id' => '[0-9]+']);
    Route::post('/settings/item/image/{id}', 'Settings\ItemController@item_image')->name('item.image')->where(['id' => '[0-9]+']);
    Route::delete('/settings/item/image/{id}', 'Settings\ItemController@item_image_delete')->name('item.image_delete')->where(['id' => '[0-9]+']);
    Route::put('/settings/item/image/{id}', 'Settings\ItemController@item_image_update')->name('item.image_update')->where(['id' => '[0-9]+']);
    Route::resource('/settings/occasion', 'Settings\OccasionController')->except(['update']);
    Route::put('/settings/occasion/{id}/{type}', 'Settings\OccasionController@update')->name('occasion.update')->where(['id' => '[0-9]+', 'type' => '[1|0|2]']);
    Route::resource('/settings/color', 'Settings\ColorsController')->except(['update']);
    Route::put('/settings/color/{id}/{type}', 'Settings\ColorsController@update')->name('color.update')->where(['id' => '[0-9]+', 'type' => '[1|0|2]']);
    Route::resource('/settings/shop', 'Settings\ShopController')->except(['update']);
    Route::put('/settings/shop/{id}/{type}', 'Settings\ShopController@update')->name('shop.update')->where(['id' => '[0-9]+', 'type' => '[1|0]']);
    Route::post('/settings/shop/schedule/{id}', 'Settings\ShopController@schedule_add')->name('shop.schedule_add')->where(['id' => '[0-9]+']);
    Route::delete('/settings/shop/schedule/{id}', 'Settings\ShopController@schedule_delete')->name('shop.schedule_delete')->where(['id' => '[0-9]+']);
    Route::resource('/settings/taxi', 'Settings\TaxiController')->except(['update']);
    Route::put('/settings/taxi/{id}/{type}', 'Settings\TaxiController@update')->name('taxi.update')->where(['id' => '[0-9]+', 'type' => '[1|0]']);
    Route::post('/settings/taxi/schedule/{id}', 'Settings\TaxiController@schedule_add')->name('taxi.schedule_add')->where(['id' => '[0-9]+']);
    Route::delete('/settings/taxi/schedule/{id}', 'Settings\TaxiController@schedule_delete')->name('taxi.schedule_delete')->where(['id' => '[0-9]+']);
    Route::resource('/settings/home', 'Settings\HomeController');
    Route::resource('/settings/about', 'Settings\AboutController');
    Route::resource('/settings/terms', 'Settings\TermAndCondController');
    Route::post('/settings/home/extra', 'Settings\HomeController@store_extra')->name('home.store_extra');
    Route::post('/settings/about/footer', 'Settings\AboutController@store_footer')->name('about.store_footer');
    Route::resource('/settings/contact', 'Settings\ContactAsController');
    Route::get('/settings/Q&A', 'Settings\QandAController@index')->name('Q&A.index');
    Route::get('/settings/Q&A/{id}', 'Settings\QandAController@show')->name('Q&A.show');
    Route::get('/settings/Q&A/{id}/edit', 'Settings\QandAController@edit')->name('Q&A.edit');
    Route::post('/settings/Q&A', 'Settings\QandAController@store')->name('Q&A.store');
    Route::delete('/settings/Q&A/{id}', 'Settings\QandAController@destroy')->name('Q&A.destroy');
    Route::put('/settings/Q&A/{id}/{type}', 'Settings\QandAController@update')->name('Q&A.update')->where(['id' => '[0-9]+', 'type' => '[1|0]']);
    Route::resource('/settings/orders', 'Settings\OrdersController')->except(['edit']);
    Route::get('/settings/orders/{order}/{group}/edit', 'Settings\OrdersController@edit')->name('orders.edit')->where(['order' => '[0-9]+', 'group' => '[0-9]+']);
    Route::post('/settings/orders/{order}/{group}/search', 'Settings\OrdersController@search')->name('orders.search')->where(['order' => '[0-9]+', 'group' => '[0-9]+']);
    Route::post('/settings/orders/send/taxi/{id}', 'Settings\OrdersController@sendtaxi')->name('orders.sendtaxi')->where(['id' => '[0-9]+']);
    Route::delete('/settings/orders/reject/{id}', 'Settings\OrdersController@reject')->name('orders.reject')->where(['id' => '[0-9]+']);
    Route::delete('/settings/taxi/reject/{order}/{taxi}', 'Settings\OrdersController@reject_delivery')->name('orders.reject_delivery')->where(['order' => '[0-9]+', 'taxi' => '[0-9]+']);
    Route::post('/settings/taxi/accept/{order}/{taxi}', 'Settings\OrdersController@accept_delivery')->name('orders.accept_delivery')->where(['order' => '[0-9]+', 'taxi' => '[0-9]+']);
});
Route::resource('/', 'Website\HomeController');
Route::resource('/about', 'Website\AboutController');
Route::get('/item/{id}', 'Website\ShowItemController@show')->name('item.show');
Route::post('/item/{id}', 'Website\ShowItemController@store')->name('item.orderstore')->middleware('clinteauth');
Route::delete('/order/{id}', 'Website\ShowItemController@destroy')->name('order.delete')->middleware('clinteauth');
Route::get('/orders', 'Website\ShowItemController@carts')->name('order.carts')->middleware('clinteauth');
Route::put('/orders/{id}', 'Website\ShowItemController@edit')->name('edit.carts')->middleware('clinteauth');
Route::put('/orders/redirectErrorEdit', 'Website\ShowItemController@redirectErrorEdit')->name('edit.error')->middleware('clinteauth');
Route::resource('/order/custom', 'Website\CustomOrderController')->middleware('clinteauth');
Route::resource('/profile', 'Website\ProfileController')->middleware('clinteauth');
Route::get('/account/login', 'Website\AuthenticationController@index')->name('login.show');
Route::post('/account/app/login', 'Website\AuthenticationController@login')->name('login.login');
Route::get('/account/register', 'Website\AuthenticationController@registerShow')->name('login.create');
Route::post('/account/app/register', 'Website\AuthenticationController@register')->name('login.register');
Route::get('/account/verify/{id}', 'Website\AuthenticationController@verify')->name('login.verify')->where(['id' => '[0-9]+']);
Route::post('/account/verify/{id}', 'Website\AuthenticationController@check')->name('login.checkaccount')->where(['id' => '[0-9]+']);
Route::get('/account/logout', 'Website\AuthenticationController@logout')->name('login.logout')->middleware('clinteauth');
Route::get('/account/change_password', 'Website\AuthenticationController@passwordshow')->name('login.passwordshow')->middleware('clinteauth');
Route::post('/account/change_password_done', 'Website\AuthenticationController@passwordchange')->name('login.passwordchange')->middleware('clinteauth');
Route::get('/order/submit/{type}', 'Website\OrderControllerFinish@index')->name('submit.order')->middleware('clinteauth')->where('type', '[1|0]');
Route::get('/map/save/{type}', 'Website\OrderControllerFinish@map')->name('submit.map')->middleware('clinteauth')->where('type', '[1|0]');
Route::post('/map/done/{type}', 'Website\OrderControllerFinish@savedmap')->name('submit.savedmap')->middleware('clinteauth')->where('type', '[1|0]');
Route::post('/order/done/{type}', 'Website\OrderControllerFinish@done')->name('submit.done')->middleware('clinteauth')->where('type', '[1|0]');
Route::delete('/map/delete', 'Website\OrderControllerFinish@deletemap')->name('submit.deletemap')->middleware('clinteauth');
Route::get('/my-orders', 'Website\MyOrdersControllers@index')->name('order.index')->middleware('clinteauth');
Route::get('/my-orders/{id}', 'Website\MyOrdersControllers@show')->name('order.show')->middleware('clinteauth');
Route::get('/search', 'Website\SearchAndFilterController@index')->name('search.index');
Route::post('/search', 'Website\SearchAndFilterController@search')->name('search.search');

Route::get('/contact', 'Website\ContactAsController@index')->name('contact.index');
Route::post('/contact', 'Website\ContactAsController@mail')->name('contact.mail');
Route::get('/Q&A', 'Website\QAController@index')->name('qanda.index');
Route::get('/TermsAndConditions', 'Website\TermAndCond@index')->name('term.index');
