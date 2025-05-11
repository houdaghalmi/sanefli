<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminRecipeController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminIngredientController;
use App\Http\Controllers\AdminPreparationController;

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
    return view('home');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

    
Route::middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/admin/dashboard', [ProfileController::class, 'index']);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('recipes', AdminRecipeController::class);
    Route::resource('ingredients', AdminIngredientController::class);
    Route::resource('preparations', AdminPreparationController::class);

});
    



Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [ProfileController::class, 'index']);
    // other user routes
});

require __DIR__.'/auth.php';
