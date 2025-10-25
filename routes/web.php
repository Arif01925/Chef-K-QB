<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

// Fallback route to serve files from storage/app/public in case the
// public/storage symlink is missing or can't be used on the host.
Route::get('/_s/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);
    if (!file_exists($file)) {
        abort(404);
    }
    $mime = mime_content_type($file) ?: 'application/octet-stream';
    return Response::make(file_get_contents($file), 200, [
        'Content-Type' => $mime,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*');

// Profile page (require authentication)
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return view('login');
});

use App\Http\Controllers\AuthController;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Income Routes
Route::get('/income', [IncomeController::class, 'index'])->name('income.index');
Route::get('/income/create', [IncomeController::class, 'create'])->name('income.create');
Route::post('/income/store', [IncomeController::class, 'store'])->name('income.store');

// Expense Routes
Route::get('/expense', [ExpenseController::class, 'index'])->name('expense.index');
Route::get('/expense/create', [ExpenseController::class, 'create'])->name('expense.create');
Route::post('/expense/store', [ExpenseController::class, 'store'])->name('expense.store');

// Invoice Routes
Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
Route::post('/invoices/store', [InvoiceController::class, 'store'])->name('invoices.store');
Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

Route::get('/expense', [ExpenseController::class, 'index'])->name('expense.index');
Route::get('/expense/create', [ExpenseController::class, 'create']);
Route::post('/expense/store', [ExpenseController::class, 'store'])->name('expense.store');


use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');

Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::post('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/payroll', function () {
    return view('payroll.index');
})->name('payroll.index');
use App\Http\Controllers\PayrollController;

Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
Route::post('/payroll', [PayrollController::class, 'store'])->name('payroll.store');
Route::get('/payroll/mark-paid/{id}', [PayrollController::class, 'markAsPaid'])->name('payroll.markAsPaid');
Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
Route::post('/payroll', [PayrollController::class, 'store'])->name('payroll.store');
Route::get('/payroll/edit/{id}', [PayrollController::class, 'edit'])->name('payroll.edit');
Route::put('/payroll/update/{id}', [PayrollController::class, 'update'])->name('payroll.update');
Route::get('/payroll/delete/{id}', [PayrollController::class, 'destroy'])->name('payroll.delete');
Route::get('/payroll/mark-paid/{id}', [PayrollController::class, 'markAsPaid'])->name('payroll.markAsPaid');
Route::get('/payroll/summary', [PayrollController::class, 'summary'])->name('payroll.summary');

use App\Http\Controllers\EmployeeController;

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::post('/employees/update/{id}', [EmployeeController::class, 'update'])->name('employees.update');
Route::get('/employees/delete/{id}', [EmployeeController::class, 'destroy'])->name('employees.delete');
Route::post('/payroll/toggle-status', [PayrollController::class, 'toggleStatus']);



Route::get('/payroll/print', [PayrollController::class, 'print'])->name('payroll.print');

// Debug route: returns simple DB latency (milliseconds) and a success flag
Route::get('/_debug/db-latency', function () {
    try {
        $start = microtime(true);
        // run a tiny query
        \DB::select('select 1');
        $end = microtime(true);
        return response()->json([
            'ok' => true,
            'latency_ms' => round(($end - $start) * 1000, 2),
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'ok' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
});

// Profile image debug (authenticated) - returns info about user's photo paths
Route::get('/_profile_debug', function () {
    if (!\Illuminate\Support\Facades\Auth::check()) {
        return response()->json(['auth' => false, 'message' => 'not authenticated'], 200);
    }
    $user = \Illuminate\Support\Facades\Auth::user();
    $photo = $user->photo;
    $storageUrl = null;
    try {
        $storageUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($photo);
    } catch (\Throwable $e) {
        $storageUrl = null;
    }
    $storageAppFile = storage_path('app/public/' . ($photo ?? ''));
    $publicFile = public_path('storage/' . ($photo ?? ''));
    return response()->json([
        'auth' => true,
        'user_id' => $user->id,
        'user_name' => $user->name,
        'photo_db' => $photo,
        'storage_url' => $storageUrl,
        'storage_app_file_exists' => file_exists($storageAppFile),
        'storage_app_file' => $storageAppFile,
        'public_storage_file_exists' => file_exists($publicFile),
        'public_storage_file' => $publicFile,
        'suggested_urls' => [
            'storage_path' => $storageUrl ? parse_url($storageUrl, PHP_URL_PATH) : null,
            'public_storage' => '/storage/' . ($photo ?? ''),
            'fallback' => '/_s/' . ($photo ?? ''),
        ],
    ]);
})->middleware('auth');

Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
Route::get('/settings/profile', [App\Http\Controllers\SettingsController::class, 'editProfile'])->name('settings.profile');
Route::post('/settings/profile', [App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.profile.update');
Route::get('/settings/password', [App\Http\Controllers\SettingsController::class, 'editPassword'])->name('settings.password');
Route::post('/settings/password', [App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.password.update');
Route::post('/settings/toggle-theme', [App\Http\Controllers\SettingsController::class, 'toggleTheme'])->name('settings.toggleTheme');
Route::post('/settings/toggle-notifications', [App\Http\Controllers\SettingsController::class, 'toggleNotifications'])->name('settings.toggleNotifications');

// Settings Routes
Route::post('/settings/app', [App\Http\Controllers\SettingsController::class, 'updateApp'])->name('settings.app');
Route::post('/settings/company', [App\Http\Controllers\SettingsController::class, 'updateCompany'])->name('settings.company');
Route::post('/settings/integrations', [App\Http\Controllers\SettingsController::class, 'updateIntegrations'])->name('settings.integrations');

