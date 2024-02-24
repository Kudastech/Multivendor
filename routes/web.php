<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SectionController;
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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){

    Route::match(['get', 'post'],'login', [AdminController::class, 'login']);

    Route::group(['middleware' => ['admin']], function(){

        Route::get('dashboard', [AdminController::class, 'dashboard']);

        Route::match(['get', 'post'], 'update-admin-password', [AdminController::class, 'updateAdminPassword']);

        Route::post('check-admin-password', [AdminController::class, 'checkAdminPassword']);

        Route::match(['get', 'post'], 'update-admin-details', [AdminController::class, 'updateAdminDetails']);

        Route::get('logout', [AdminController::class, 'logout']);

        // View Vendor Details

        Route::get('view-vendor-details/{id}','AdminController@viewVendorDetails');

        // Updating Vendor details.
        Route::match(['get', 'post'], 'update-vendor-details/{slug}', 'AdminController@updateVendorDetails');

        // View admins/ subamins  / Vendor

        Route::get('admins/{type?}', 'AdminController@admins');

        // Update Admin Status

        Route::post('update-admin-status', 'AdminController@updateAdminStatus');


        // Section

        Route::get('sections', 'SectionController@sections');

        //Updating Section Status

        Route::post('update-section-status', 'SectionController@updateSectionStatus');

// Delete Section Status

        Route::get('delete-section/{id}', 'SectionController@deleteSection');

        // Edit Section Status

        Route::match(['get','post'], 'add-edit-section/{id?}', 'SectionController@addEditSection');

        // categories
        Route::get('categories', 'CategoryController@categories');
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory');
        Route::get('append-categories-level','CategoryController@appendCategoryLevel');
    });
});


