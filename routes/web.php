<?php

use App\Http\Controllers\Admin\AuditTrailController;
use App\Http\Controllers\Admin\CommonDeleteController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\HazardController;
use App\Http\Controllers\Admin\MobileContentController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mews\Captcha\CaptchaController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;

use App\Http\Controllers\Auth\ChangePasswordController;

// Route::get('/', [AuthController::class, 'showLogin']);
Route::get('/auth/adminLogin', function () {
    return view('auth.login');
})->name('login');
Route::post('/auth/adminLogin', [LoginController::class, 'login'])->name('admin.login.post');
Route::redirect('/', 'auth/adminLogin');

Route::get('captcha/{config?}', [CaptchaController::class, 'getCaptcha']);

Auth::routes();
Route::get('/login', function () {
    return redirect('/auth/adminLogin');
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
	Route::get('/edit-profile', [ProfileController::class, 'editprofile'])->name('editprofile');
    Route::post('/updateprofile', [ProfileController::class, 'update'])->name('updateprofile');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

    Route::get('/profile', [ProfileController::class, 'view'])->name('profile.view');
    Route::get('change-password', [ChangePasswordController::class, 'index'])->name('password.change');
    Route::post('change-password', [ChangePasswordController::class, 'update'])->name('password.update');


    Route::resource('/manage-hazard', HazardController::class);
    Route::resource('/manage-user', UserManagementController::class);
    Route::resource('/manage-state', StateController::class);
    Route::resource('/manage-district', DistrictController::class);

    Route::resource('/mobile-content', MobileContentController::class);

    Route::post('/get-districts', [HazardController::class, 'getDistricts'])->name('get.districts');
    Route::post('/get-hazard-state-image', [HazardController::class, 'getHazardStateImage'])->name('get.hazardStateImage');

	//Manage feedback
    Route::resource('/manage-feedback',FeedbackController::class);
    Route::post('/manage-feedback/{id}/reply', [FeedbackController::class, 'feedbackReply'])->name('manage-feedback.reply');

    //Delete file
    Route::get('/delete-file', [CommonDeleteController::class, 'delete'])->name('file.delete');

    //Audit trails
    Route::resource('/audit-trails', AuditTrailController::class);
});


				