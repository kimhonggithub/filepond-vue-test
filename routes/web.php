<?php

use App\Http\Controllers\DeleteTemporaryImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StorePostController;
use App\Http\Controllers\UploadTemporaryImageController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;



Route::post('/', StorePostController::class);
Route::post('/upload', UploadTemporaryImageController::class);
Route::delete('/revert', DeleteTemporaryImageController::class);

Route::get('/view', ViewController::class)->name('view');
Route::get('/', WelcomeController::class)->name('welcome');
Route::get('/storage/images/{filename}', function ($filename) {
    $filePath = storage_path('app/images/' . $filename);

    if (!Storage::exists('images/' . $filename)) {
        abort(404);
    }
   

    $file = Storage::get('images/' . $filename);
    $mimeType = Storage::mimeType('images/' . $filename);

    return Response::make(file_get_contents($filePath), 200, [
        'Content-Type' => $mimeType,
        'Content-Disposition' => 'inline; filename="' . $filename . '"',
    ]);
})->where('filename', '(.*)');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});


require __DIR__ . '/auth.php';
