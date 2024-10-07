<?php

use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
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

Route::get('/test', function () {
    return view('test');
});

Route::get('/symlink', function () {
    Artisan::call('storage:link');
});

Route::get('/symlink2', function () {
    $target = $_SERVER['DOCUMENT_ROOT'] . '/storage/app/public';
    $link = $_SERVER['DOCUMENT_ROOT'] . '/public/storage';
    symlink($target, $link);
    echo "Done";
});


/**
 * Cache clear
 */
Route::get('/cache-clear', function () {
    try {
        Artisan::call('optimize:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        // Artisan::call('storage:link');
        return "Cache cleared successfully.";
    } catch (\Exception $e) {
        return "An error occurred while clearing the cache: " . $e->getMessage();
    }
});


/**
 * DB Connection route go in here
 */
Route::get('/db-connect-check', function () {
    try {
        $dbconnect = DB::connection()->getPDO();
        $dbname = DB::connection()->getDatabaseName();
        echo "Connected successfully to the database. Database name is :" . $dbname;
    } catch (Exception $e) {
        return $e->getMessage();
        echo "Error in connecting to the database";
    }
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('offers/my', [OfferController::class, 'myOffers'])->name('offers.my');
    Route::get('offers/generate/pdf', [OfferController::class, 'generateOfferPdf'])->name('offers.generate.pdf');
    Route::get('/offers/generate/excel', [OfferController::class, 'generateOfferExcel'])->name('offers.generate.excel');
    Route::post('/offers/bulk/import', [OfferController::class, 'BulkImportOffer'])->name('offers.bulk.import');

    Route::resource('offers', OfferController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
