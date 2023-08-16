<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Home\AboutController;
use App\Http\Controllers\Home\BlogCategoryController;
use App\Http\Controllers\Home\BlogController;
use App\Http\Controllers\Home\ContactController;
use App\Http\Controllers\Home\DemoController;
use App\Http\Controllers\Home\FooterController;
use App\Http\Controllers\Home\HomeSliderController;
use App\Http\Controllers\Home\PortfolioController;
use App\Http\Controllers\Pos\CategoryController;
use App\Http\Controllers\Pos\CustomerController;
use App\Http\Controllers\Pos\DefaultController;
use App\Http\Controllers\Pos\InvoiceController;
use App\Http\Controllers\Pos\ProductController;
use App\Http\Controllers\Pos\PurchaseController;
use App\Http\Controllers\Pos\StockController;
use App\Http\Controllers\Pos\SupplierController;
use App\Http\Controllers\Pos\UnitController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::controller(DemoController::class)->group(function () {
    Route::get('/', 'homeMain')->name('home');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Admin All Route
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/logout', 'destroy')->name('admin.logout');

        Route::get('/admin/profile', 'profile')->name('admin.profile');

        Route::get('/edit/profile', 'edit')->name('edit.profile');
        Route::post('/store/profile', 'storeProfile')->name('store.profile');

        Route::get('/change/password', 'changePassword')->name('change.password');
        Route::post('/update/password', 'UpdatePassword')->name('update.password');
    });

    // Customer All Route 
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customer/all', 'customerAll')->name('customer.all');

        Route::get('/customer/add', 'customerAdd')->name('customer.add');
        Route::post('/customer/store', 'customerStore')->name('customer.store');

        Route::get('/customer/edit/{id}', 'customerEdit')->name('customer.edit');
        Route::post('/customer/update', 'customerUpdate')->name('customer.update');

        Route::get('/customer/delete/{id}', 'customerDelete')->name('customer.delete');

        Route::get('/credit/customer', 'creditCustomer')->name('credit.customer');
        Route::get('/credit/customer/print/pdf', 'creditCustomerPrintPdf')->name('credit.customer.print.pdf');

        Route::get('/customer/edit/invoice/{invoice_id}', 'customerEditInvoice')->name('customer.edit.invoice');
        Route::post('/customer/update/invoice/{invoice_id}', 'customerUpdateInvoice')->name('customer.update.invoice');
    });

    // Supplier All Route 
    Route::controller(SupplierController::class)->group(function () {
        Route::get('/supplier/all', 'supplierAll')->name('supplier.all');

        Route::get('/supplier/add', 'supplierAdd')->name('supplier.add');
        Route::post('/supplier/store', 'supplierStore')->name('supplier.store');

        Route::get('/supplier/edit/{id}', 'supplierEdit')->name('supplier.edit');
        Route::post('/supplier/update', 'supplierUpdate')->name('supplier.update');

        Route::get('/supplier/delete/{id}', 'SupplierDelete')->name('supplier.delete');
    });

    // Unit All Route 
    Route::controller(UnitController::class)->group(function () {
        Route::get('/unit/all', 'unitAll')->name('unit.all');

        Route::get('/unit/add', 'unitAdd')->name('unit.add');
        Route::post('/unit/store', 'unitStore')->name('unit.store');

        Route::get('/unit/edit/{id}', 'unitEdit')->name('unit.edit');
        Route::post('/unit/update', 'unitUpdate')->name('unit.update');

        Route::get('/unit/delete/{id}', 'unitDelete')->name('unit.delete');
    });

    // Category All Route 
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category/all', 'categoryAll')->name('category.all');

        Route::get('/category/add', 'categoryAdd')->name('category.add');
        Route::post('/category/store', 'categoryStore')->name('category.store');

        Route::get('/category/edit/{id}', 'categoryEdit')->name('category.edit');
        Route::post('/category/update', 'categoryUpdate')->name('category.update');

        Route::get('/category/delete/{id}', 'categoryDelete')->name('category.delete');
    });

    // Product All Route 
    Route::controller(ProductController::class)->group(function () {
        Route::get('/product/all', 'productAll')->name('product.all');

        Route::get('/product/add', 'productAdd')->name('product.add');
        Route::post('/product/store', 'productStore')->name('product.store');

        Route::get('/product/edit/{id}', 'productEdit')->name('product.edit');
        Route::post('/product/update', 'productUpdate')->name('product.update');

        Route::get('/product/delete/{id}', 'ProductDelete')->name('product.delete');
    });

    // Purchase All Route 
    Route::controller(PurchaseController::class)->group(function () {
        Route::get('/purchase/all', 'purchaseAll')->name('purchase.all');

        Route::get('/purchase/add', 'purchaseAdd')->name('purchase.add');
        Route::post('/purchase/store', 'purchaseStore')->name('purchase.store');

        Route::get('/purchase/delete/{id}', 'purchaseDelete')->name('purchase.delete');

        Route::get('/purchase/pending', 'purchasePending')->name('purchase.pending');
        Route::get('/purchase/approve/{id}', 'purchaseApprove')->name('purchase.approve');

        Route::get('/daily/purchase/report', 'dailyPurchaseReport')->name('daily.purchase.report');
        Route::get('/daily/purchase/pdf', 'dailyPurchasePdf')->name('daily.purchase.pdf');
    });

    // Invoice All Route
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoice/all', 'invoiceAll')->name('invoice.all');

        Route::get('/invoice/add', 'invoiceAdd')->name('invoice.add');
        Route::post('/invoice/store', 'invoiceStore')->name('invoice.store');

        Route::get('/invoice/pending/list', 'pendingList')->name('invoice.pending.list');
        Route::get('/invoice/delete/{id}', 'invoiceDelete')->name('invoice.delete');

        Route::get('/invoice/approve/{id}', 'invoiceApprove')->name('invoice.approve');
        Route::post('/approval/store/{id}', 'approvalStore')->name('approval.store');

        Route::get('/print/invoice/list', 'printInvoiceList')->name('print.invoice.list');
        Route::get('/print/invoice/{id}', 'printInvoice')->name('print.invoice');

        Route::get('/daily/invoice/report', 'dailyInvoiceReport')->name('daily.invoice.report');
        Route::get('/daily/invoice/pdf', 'DailyInvoicePdf')->name('daily.invoice.pdf');
    });

    // Stock All Route 
    Route::controller(StockController::class)->group(function () {
        Route::get('/stock/report', 'stockReport')->name('stock.report');
        Route::get('/stock/report/pdf', 'stockReportPdf')->name('stock.report.pdf');

        Route::get('/stock/supplier/wise', 'stockSupplierWise')->name('stock.supplier.wise');
        Route::get('/supplier/wise/pdf', 'supplierWisePdf')->name('supplier.wise.pdf');

        Route::get('/product/wise/pdf', 'productWisePdf')->name('product.wise.pdf');
    });
});

// Default All Route 
Route::controller(DefaultController::class)->group(function () {
    Route::get('/get-category', 'getCategory')->name('get-category');
    Route::get('/get-product', 'getProduct')->name('get-product');
    Route::get('/check-product', 'GetStock')->name('check-product-stock');
});

//Home Slide All Route
Route::controller(HomeSliderController::class)->group(function () {
    Route::get('/home/slide', 'homeSlider')->name('home.slide');
    Route::post('/update/slider', 'updateSlider')->name('update.slider');
});

//About All Route
Route::controller(AboutController::class)->group(function () {
    Route::get('/about/page', 'aboutPage')->name('about.page');
    Route::post('/update/about', 'updateAbout')->name('update.about');
    Route::get('/about', 'homeAbout')->name('home.about');

    Route::get('/about/multi/image', 'aboutMultiImage')->name('about.multi.image');
    Route::post('/store/multi/image', 'storeMultiImage')->name('store.multi.image');
    Route::get('/all/multi/image', 'allMultiImage')->name('all.multi.image');

    Route::get('/edit/multi/image/{id}', 'editMultiImage')->name('edit.multi.image');
    Route::post('/update/multi/image', 'updateMultiImage')->name('update.multi.image');

    Route::get('/delete/multi/image/{id}', 'DeleteMultiImage')->name('delete.multi.image');
});

//Portfolio All Route
Route::controller(PortfolioController::class)->group(function () {
    Route::get('/all/portfolio', 'allPortfolio')->name('all.portfolio');

    Route::get('/add/portfolio', 'addPortfolio')->name('add.portfolio');
    Route::post('/store/portfolio', 'storePortfolio')->name('store.portfolio');

    Route::get('/edit/portfolio/{id}', 'editPortfolio')->name('edit.portfolio');
    Route::post('/update/portfolio', 'updatePortfolio')->name('update.portfolio');

    Route::get('/delete/portfolio/{id}', 'deletePortfolio')->name('delete.portfolio');

    Route::get('/portfolio/details/{id}', 'portfolioDetails')->name('portfolio.details');

    Route::get('/portfolio', 'homePortfolio')->name('home.portfolio');
});

// Blog Category All Routes 
Route::controller(BlogCategoryController::class)->group(function () {
    Route::get('/all/blog/category', 'allBlogCategory')->name('all.blog.category');

    Route::get('/add/blog/category', 'addBlogCategory')->name('add.blog.category');
    Route::post('/store/blog/category', 'storeBlogCategory')->name('store.blog.category');

    Route::get('/edit/blog/category/{id}', 'editBlogCategory')->name('edit.blog.category');
    Route::post('/update/blog/category/{id}', 'updateBlogCategory')->name('update.blog.category');

    Route::get('/delete/blog/category/{id}', 'deleteBlogCategory')->name('delete.blog.category');
});

// Blog All Routes 
Route::controller(BlogController::class)->group(function () {
    Route::get('/all/blog', 'allBlog')->name('all.blog');

    Route::get('/add/blog', 'addBlog')->name('add.blog');
    Route::post('/store/blog', 'storeBlog')->name('store.blog');

    Route::get('/edit/blog/{id}', 'editBlog')->name('edit.blog');
    Route::post('/update/blog', 'updateBlog')->name('update.blog');

    Route::get('/delete/blog/{id}', 'deleteBlog')->name('delete.blog');

    Route::get('/blog/details/{id}', 'blogDetails')->name('blog.details');
    Route::get('/category/blog/{id}', 'categoryBlog')->name('category.blog');

    Route::get('/blog', 'homeBlog')->name('home.blog');
});

Route::controller(FooterController::class)->group(function () {
    Route::get('/footer/setup', 'FooterSetup')->name('footer.setup');

    Route::post('/update/footer', 'UpdateFooter')->name('update.footer');
});

// Contact All Route 
Route::controller(ContactController::class)->group(function () {
    Route::get('/contact', 'contact')->name('contact.me');

    Route::post('/store/message', 'storeMessage')->name('store.message');

    Route::get('/contact/message', 'contactMessage')->name('contact.message');
    Route::get('/delete/message/{id}', 'deleteMessage')->name('delete.message');
});

require __DIR__ . '/auth.php';
