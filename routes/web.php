<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\wishlistController;
use App\Http\Controllers\productController;
use App\Http\Controllers\addressController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\profileController;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Schema;




Route::get('/',[HomeController::class, 'index']);
Route::post('/addcart',[cartController::class, 'additem']);
Route::post('/addwish',[wishlistController::class, 'addwish']);


Auth::routes();

Route::get('/product/{url}', [productController::class, 'product'])->name('product');
Route::get('/category/{cat_name}', [productController::class, 'category'])->name('category');
Route::get('/shop', [productController::class, 'products'])->name('products');
Route::post('/filter', [productController::class, 'filter'])->name('filter');
Route::get('/wishlist', [wishlistController::class, 'wishlist'])->name('wishlist');
Route::get('/wishdelete/{id}', [wishlistController::class, 'wishdelete'])->name('wishdelete');
Route::get('/cart', [cartController::class, 'cart'])->name('cart');
Route::post('/gcart', [cartController::class, 'guestcart'])->name('guestcart');
Route::post('/updateguestcart', [cartController::class, 'editguestcart'])->name('editguestcart');
Route::post('/updatecart', [cartController::class, 'updatecart'])->name('updatecart');
Route::delete('/delcartitem', [cartController::class, 'delCartItem'])->name('delCartItem');
Route::post('/checkout',[addressController::class, 'checkout'])->name("checkout");
Route::post('/guest-checkout',[addressController::class, 'guestcheckout'])->name("guestcheckout");
Route::post('/addaddress', [addressController::class, 'addaddress'])->name('addaddress');
Route::patch('/update-address', [addressController::class, 'updateAddress'])->name('updateAddress');
Route::post('/payment', [addressController::class, 'payment'])->name('payment');
Route::post('/paymentProccess', [paymentController::class, 'paymentProccess'])->name('paymentProccess');
Route::post('/guest/payment', [paymentController::class, 'guestpayment'])->name('guestpayment');
Route::post('/guestitemdel', [cartController::class, 'guestitemdel'])->name('guestitemdel');
Route::post('/createorder', [paymentController::class, 'createorder'])->name('createorder');
Route::post('/razorpay', [paymentController::class, 'razorpay'])->name('razorpay');
Route::post('/failedpayments', [paymentController::class, 'failedpayments'])->name('failedpayments');


Route::get('thankyou',[paymentController::class, 'thankyou']);
Route::get('myorders',[orderController::class, 'myOrders']);
Route::post('order-cancel', [orderController::class, 'orderCancel'])->name('orderCancel');
Route::get('generate-invoice/{id}', [orderController::class, 'generateInvoice'])->name('generateInvoice');
Route::get('search-order/{id}', [orderController::class, 'searchOrder'])->name('searchOrder');
Route::post('order-filter', [orderController::class, 'orderFilter'])->name('orderFilter');
Route::get('profile',[profileController::class, 'profile']);
Route::post('profile',[profileController::class, 'updateProfile']);
Route::post('change-password',[profileController::class, 'changePassword']);
Route::POST('search',[HomeController::class, 'search']);





Route::get('/test',function()
{

    return view('pages.profile');
    $key_id = env('RKEY_ID',null);
    $secret = env('RSECRET_KEY',null);
    
    $api = new Api($key_id, $secret);
    $customer = $api->customer->create(array('name' => \Auth::user()->name, 'email' => "testdemo6956@gmail.com",'contact'=> '9066373227'));
    $items = $api->item->create(array('name' => "text", 'amount' => '10000',"currency"=> "INR"));
    $data = $api->invoice->create(array ('type' => 'invoice','date' => 1589994898, 'customer_id'=> $customer->id, 'line_items'=>array(array('item_id'=>$items->id))));

    return "hello";
});






