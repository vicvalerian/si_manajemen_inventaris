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

//Admin All Route
Route::middleware(['auth'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/logout', 'destroy')->name('admin.logout');

        Route::get('/admin/profile', 'profile')->name('admin.profile');

        Route::get('/edit/profile', 'edit')->name('edit.profile');
        Route::post('/store/profile', 'storeProfile')->name('store.profile');

        Route::get('/change/password', 'changePassword')->name('change.password');
        Route::post('/update/password', 'UpdatePassword')->name('update.password');
    });
});

// Customer All Route 
Route::controller(CustomerController::class)->group(function () {
    Route::get('/customer/all', 'customerAll')->name('customer.all');

    Route::get('/customer/add', 'customerAdd')->name('customer.add');
    Route::post('/customer/store', 'customerStore')->name('customer.store');

    Route::get('/customer/edit/{id}', 'customerEdit')->name('customer.edit');
    Route::post('/customer/update', 'customerUpdate')->name('customer.update');

    Route::get('/customer/delete/{id}', 'CustomerDelete')->name('customer.delete');
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
