<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\Home::class)->name('home');

Route::get('/login', App\Livewire\Login::class)->name('login');

Route::post('/auth/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp']);
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth');

// Language Switching
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'hi', 'gu', 'mr', 'te', 'ta'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/book', App\Livewire\OnlineBooking::class)->name('booking.online');
Route::get('/faq', App\Livewire\Public\Faq::class)->name('faq');
Route::get('/policies', App\Livewire\Public\Policies::class)->name('policies');
Route::get('/festivals', App\Livewire\Public\Festivals::class)->name('festivals');

Route::middleware(['auth'])->group(function () {
    Route::get('/rooms', App\Livewire\RoomMap::class)->name('rooms.map');
    Route::get('/booking/counter', App\Livewire\CounterBooking::class)->name('booking.counter');
    Route::get('/cash/ledger', App\Livewire\CashLedger::class)->name('cash.ledger');
    Route::get('/reports', App\Livewire\CollectionReports::class)->name('collection.reports');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/test', App\Livewire\AdminDashboard::class)->name('admin.dashboard');
    Route::get('/admin/settings', App\Livewire\WebsiteSettings::class)->name('admin.settings');
    Route::get('/admin/staff', App\Livewire\Operations\StaffManager::class)->name('admin.staff');
    Route::get('/admin/attendance', App\Livewire\Operations\AttendanceScanner::class)->name('admin.attendance');
    Route::get('/admin/maintenance', App\Livewire\Operations\MaintenanceManager::class)->name('admin.maintenance');
    Route::get('/operations/expenses', App\Livewire\Operations\ExpenseManager::class)->name('expenses');
    Route::get('/operations/forecast', App\Livewire\Operations\DemandForecaster::class)->name('forecast');
});
