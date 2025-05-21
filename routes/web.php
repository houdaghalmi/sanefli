<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminRecipeController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminEtapeController;
use App\Http\Controllers\AdminIngredientController;
use App\Http\Controllers\AdminPreparationController;




use App\Http\Controllers\UserController;
use App\Http\Controllers\RecetteController;
use App\Http\Controllers\FavoriteController;


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
    Route::resource('etapes', AdminEtapeController::class);
    Route::resource('recipes', AdminRecipeController::class);
    Route::resource('ingredients', AdminIngredientController::class);
    Route::resource('preparations', AdminPreparationController::class);

});
    



Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [ProfileController::class, 'index']);
    
    /*Route::resource('/recipes', [UserRecetteController::class]);
    Route::resource('/favorites', [UserFavoriteController::class]);
    
    /*
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Page de recherche de recettes
    Route::get('/recette/search', function () {
        return view('user.recette');
    })->name('recette.search');

    // Page détail d'une recette
    Route::get('/recette/detail', function () {
        return view('user.recetteDetaille');
    })->name('recette.detail');

    // Liste des favoris
    Route::get('/user/favorites', function () {
        return view('user.favorites');
    })->name('favorites.index');

    */
});

require __DIR__.'/auth.php';
