<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\cartitemController;
use App\Http\Controllers\order_tableController;
use App\Http\Controllers\orderdtController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\productController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Raw;
use App\Http\Kernel;
use App\Models\Order_table;
use App\Models\User;

// hiển thị trang chủ
Route::get('/', function () {
    return view('products.index');
})->name('home');

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [userController::class, 'register'])
                ->name('register');
    Route::post('/register', [userController::class, 'acpregister'])
                ->name('acpregister');
    Route::get('/login', [userController::class, 'login'])
                ->name('login');
    Route::post('/login', [userController::class, 'checklogin'])
                ->name('checklogin');
});


Route::middleware('auth')->group(function () {
        Route::post('/logout', [userController::class, 'logout'])
            ->name('logout');
        Route::get('/cart', [cartitemController::class, 'index'])
            ->name('cartitems');
        Route::post('/cart',[cartitemController::class,'add'])
            ->name('additems');
        Route::delete('/cart/remove/{id}',[cartitemController::class,'remove'])
            ->name('removeitem');
});

Route::middleware(['auth','auth.admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/admin/dashboard', [adminController::class,'index'])
    ->name('dashboard');
    //product
    Route::post('/admin/payment/verify/{id}',[adminController::class, 'verifyPayment'])->name('admin.payment.verify');
    Route::get('/products',                     [productController::class, 'indexProduct'])->name('products.indexProduct');
    Route::get('/products/create',              [productController::class, 'create'])->name('products.create');
    Route::post('/products/store',              [productController::class, 'store'])->name('products.store');
    Route::get('/products/edit/{id}',           [productController::class, 'edit'])->name('products.edit');
    Route::put('/products/update/{id}',         [productController::class, 'update'])->name('products.update');
    Route::delete('/products/delete/{id}',      [productController::class, 'delete'])->name('products.delete');
    //order
    Route::get('/order_table',                  [Order_tableController::class, 'indexOrder'])->name('order.indexOrder');
    Route::get('//order_details/{id}',          [Order_tableController::class, 'detailorder'])->name('order.detailorder');
    Route::delete('/order_table/delete/{id}',   [Order_tableController::class, 'deleteorder'])->name('order.deleteorder');
    //user
    Route::get('/user',                         [UserController::class, 'indexUser'])->name('user.indexUser');
    Route::delete('/user/delete/{id}',          [UserController::class, 'deleteuser'])->name('user.deleteuser');
    Route::get('/user/edit/{id}',               [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}',             [UserController::class, 'updateuser'])->name('user.updateuser');
    Route::put('/user/reset/{id}',              [UserController::class, 'reset'])->name('user.reset');
    //payment
    Route::get('/payment',                      [paymentController::class, 'indexPayment'])->name('payment.indexPayment');
    Route::delete('/payment/delete/{id}',       [paymentController::class, 'deletepayment'])->name('payment.deletepayment');
    //order
    Route::get('/order_bill',                   [orderdtController::class, 'indexbill'])->name('order.indexbill');
    Route::delete('/order_bill/delete/{id}',    [orderdtController::class, 'deletebill'])->name('order.deletebill');
    Route::get('/order_bill/edit/{id}',         [orderdtController::class, 'editBill'])->name('order.editBill');
    Route::put('/order_bill/update/{id}',       [orderdtController::class, 'updateBill'])->name('order.updateBill');

});

Route::get('/order_table/checkout',[order_tableController::class,'formthanhtoan'])
            ->name('formthanhtoan');
Route::post('/order_table',[order_tableController::class,'thanhtoan'])
            ->name('thanhtoan');
Route::get('/payment/qr-bank/{id}', [PaymentController::class, 'qrBank'])
    ->name('payment.qrbank');
Route::post('/payment/confirm/{id}', [PaymentController::class, 'confirm'])
    ->name('payment.confirm');

Route::get('/products/{id}',[productController::class,'show'])->name('detail');

Route::get('/products',[productController::class,'search'])->name('search');



// Database test routes
Route::prefix('test-db')->group(function () {
    // Test database connection
    Route::get('/connection', function () {
        try {
            DB::connection()->getPdo();
                return view('products.connection');
        } catch (\Exception $e) {
            return "Kết nối THẤT BẠI. Lỗi: " . $e->getMessage();
        }
    });
});
