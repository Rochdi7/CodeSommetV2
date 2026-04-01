<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\BudgetController;
use App\Http\Controllers\Admin\HomeAdController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\NewsletterAdminController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes - CodeSommet
|--------------------------------------------------------------------------
|
| All routes return Blade views directly. For pages that need dynamic
| data (contact form, tools), add controllers as needed.
|
*/

// ─── Core Pages ──────────────────────────────────────────────────────────────

Route::view('/', 'pages.home')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/get-quote', 'pages.get-quote')->name('get-quote');
Route::view('/our-work', 'pages.our-work')->name('our-work');
Route::view('/industries', 'pages.industries')->name('industries');
Route::view('/locations', 'pages.locations')->name('locations');
Route::view('/tools', 'pages.tools')->name('tools');

// ─── Legal Pages ─────────────────────────────────────────────────────────────

Route::prefix('legal')->group(function () {
    Route::view('/privacy-policy', 'pages.legal.privacy-policy')->name('privacy-policy');
    Route::view('/terms-of-service', 'pages.legal.terms-of-service')->name('terms-of-service');
    Route::view('/refund-policy', 'pages.legal.refund-policy')->name('refund-policy');
    Route::view('/cookie-policy', 'pages.legal.cookie-policy')->name('cookie-policy');
    Route::view('/acceptable-use', 'pages.legal.acceptable-use')->name('acceptable-use');
});

// ─── Service / Industry Pages (SEO Landing Pages) ───────────────────────────
// URL: /services/{slug}
// Example: /services/ecommerce-website-development

$servicePages = [
    'ecommerce-website-development-agency',
    'saas-platform-development-agency',
    'fintech-platform-development-agency',
    'fintech-website-development-agency',
    'healthcare-website-development-agency',
    'education-website-development-agency',
    'edtech-platform-development-agency',
    'elearning-platform-development-agency',
    'online-course-platform-development-agency',
    'university-website-development-agency',
    'language-school-website-development-agency',
    'study-abroad-website-development-agency',
    'immigration-consultancy-website-development-agency',
    'real-estate-website-development-agency',
    'telemedicine-platform-development-agency',
    'telemedicine-website-development-agency',
];

Route::get('/services/{slug}', function (string $slug) use ($servicePages) {
    if (! in_array($slug, $servicePages)) {
        abort(404);
    }
    $view = "pages.services.{$slug}";
    if (! view()->exists($view)) {
        abort(404);
    }
    return view($view);
})->where('slug', '[a-z\-]+')->name('service');

// ─── Location / City Pages (SEO Landing Pages) ──────────────────────────────
// URL: /web-development/{city}
// Example: /web-development/dubai

$cityPages = [
    'worldwide',
    'casablanca', 'marrakech', 'rabat', 'tangier',
    'dubai', 'abudhabi', 'riyadh', 'doha', 'kuwait-city',
    'london', 'amsterdam', 'berlin', 'paris', 'copenhagen',
    'dublin', 'brussels', 'zurich', 'stockholm',
    'madrid', 'barcelona', 'lisbon', 'rome', 'milan',
    'new-york', 'san-francisco', 'los-angeles', 'austin',
    'seattle', 'boston', 'chicago', 'denver', 'toronto', 'vancouver',
    'tunis', 'cairo', 'lagos',
];

Route::get('/web-development-company/{city}', function (string $city) use ($cityPages) {
    if (! in_array($city, $cityPages)) {
        abort(404);
    }
    $view = "pages.locations.web-development-company-{$city}";
    if (! view()->exists($view)) {
        abort(404);
    }
    return view($view);
})->where('city', '[a-z\-]+')->name('location');

// ─── Tools Pages ─────────────────────────────────────────────────────────────
// URL: /tools/{slug}
// Example: /tools/website-analyzer

Route::get('/tools/{slug}', function (string $slug) {
    $view = "pages.tools.{$slug}";
    if (! view()->exists($view)) {
        abort(404);
    }
    return view($view);
})->where('slug', '[a-z0-9\-]+')->name('tool');

// ─── Our Work / Case Study Pages ────────────────────────────────────────────
// URL: /our-work/{slug}
// Example: /our-work/glamworlds

Route::get('/our-work/{slug}', function (string $slug) {
    $view = "pages.our-work.{$slug}";
    if (! view()->exists($view)) {
        abort(404);
    }
    return view($view);
})->where('slug', '[a-z\-]+')->name('case-study');

// ─── Blog ───────────────────────────────────────────────────────────────────
// URL: /blog, /blog/{slug}

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/preview', function () { return view('pages.blog.preview'); })->name('blog.preview');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->where('slug', '[a-z0-9\-]+')->name('blog.show');

// ─── Newsletter (Public) ─────────────────────────────────────────────────────

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// ─── Admin Authentication ────────────────────────────────────────────────────

Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::middleware('super_admin')->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Projects Management
    Route::resource('projects', ProjectController::class);
    Route::post('/projects/{project}/update-status',   [ProjectController::class, 'updateStatus'])->name('projects.update-status');
    Route::post('/projects/{project}/update-progress', [ProjectController::class, 'updateProgress'])->name('projects.update-progress');
    Route::post('/projects/{project}/add-payment',     [ProjectController::class, 'addPayment'])->name('projects.add-payment');
    Route::post('/projects/{project}/generate-schedule', [ProjectController::class, 'generatePaymentSchedule'])->name('projects.generate-schedule');
    Route::post('/projects/{project}/update-phases',    [ProjectController::class, 'updatePhases'])->name('projects.update-phases');

    // Payments
    Route::resource('payments', PaymentController::class);
    Route::get('/projects/{project}/payments', [PaymentController::class, 'byProject'])->name('projects.payments');

    // Finance Tracking
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance');
    Route::post('/finance/expense', [FinanceController::class, 'storeExpense'])->name('finance.expense.store');
    Route::delete('/finance/expense/{expense}', [FinanceController::class, 'destroyExpense'])->name('finance.expense.destroy');

    // Blog Management
    Route::resource('blog', BlogPostController::class);

    // Media Library
    Route::get('/media/picker', [MediaController::class, 'picker'])->name('media.picker');
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media/upload', [MediaController::class, 'upload'])->name('media.upload');
    Route::post('/media/{medium}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('/media/{medium}', [MediaController::class, 'destroy'])->name('media.destroy');

    // Newsletter Management
    Route::get('/newsletter/export', [NewsletterAdminController::class, 'export'])->name('newsletter.export');
    Route::get('/newsletter', [NewsletterAdminController::class, 'index'])->name('newsletter.index');
    Route::delete('/newsletter/{subscriber}', [NewsletterAdminController::class, 'destroy'])->name('newsletter.destroy');

    // Personal Budget
    Route::get('/budget/lock',      [BudgetController::class, 'showLock'])->name('budget.lock');
    Route::post('/budget/unlock',   [BudgetController::class, 'unlock'])->name('budget.unlock');
    Route::post('/budget/lock',     [BudgetController::class, 'lock'])->name('budget.lock.out');
    Route::post('/budget/salary',   [BudgetController::class, 'saveSalary'])->name('budget.salary');
    Route::post('/budget/start',    [BudgetController::class, 'startTracking'])->name('budget.start');
    Route::get('/budget',           [BudgetController::class, 'index'])->name('budget.index');
    Route::post('/budget',          [BudgetController::class, 'store'])->name('budget.store');
    Route::delete('/budget/{entry}',[BudgetController::class, 'destroy'])->name('budget.destroy');

    // Home Ads
    Route::get('/home-ads', [HomeAdController::class, 'index'])->name('home-ads.index');
    Route::post('/home-ads/{homeAd}', [HomeAdController::class, 'update'])->name('home-ads.update');
    Route::post('/home-ads/{homeAd}/toggle', [HomeAdController::class, 'toggle'])->name('home-ads.toggle');
});
