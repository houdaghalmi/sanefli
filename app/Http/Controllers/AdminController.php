<?php

namespace App\Http\Controllers;

use App\Models\Recette;
use App\Models\User;
use App\Models\Preparation;
use App\Models\Ingredient;
use App\Models\Category;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data = [
            'totalRecipes' => Recette::count(),
            'totalIngredients' => Ingredient::count(),
            'totalUsers' => User::count(),
            'totalCategories' => Category::count(),
            'totalPreparations' => Preparation::count(),
        ];

        return view('admin.dashboard', $data);
    }
}
