<?php

namespace App\Http\Controllers;

use App\Models\Recette;
use App\Models\Ingredient;
use App\Models\Category;
use App\Models\Fav;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRecipeController extends Controller
{
    public function index(Request $request)
    {
        $query = Recette::with(['ingredients', 'category']);
        
        // Filter by categories if provided
        if ($request->has('categories')) {
            $query->whereIn('id_category', $request->input('categories'));
        }
        
        $recipes = $query->paginate(12);
        
        return view('user.recipes.index', compact('recipes'));
    }

public function show(string $id)
{
    $recipe = Recette::with([
        'category',
        'ingredients', 
        'preparation',
        'preparation.etapes' => function($query) {
            $query->orderBy('numero');
        }
       
    ])->findOrFail($id);

    $similarRecipes = Recette::where('id_category', $recipe->id_category)
        ->where('id', '!=', $recipe->id)
        ->with(['category'])
        ->limit(3)
        ->get();

    return view('user.recipes.show', [
        'recipe' => $recipe,
        'similarRecipes' => $similarRecipes
    ]);
}

    public function autocompleteIngredients(Request $request)
    {
        $query = $request->get('query');
        
        $ingredients = Ingredient::where('name', 'like', '%' . $query . '%')
            ->orderByRaw("CASE WHEN name LIKE '" . $query . "%' THEN 1 ELSE 2 END")
            ->orderBy('name')
            ->limit(10)
            ->get();
            
        $result = [];
        foreach ($ingredients as $ingredient) {
            $result[] = [
                'label' => $ingredient->name,
                'value' => $ingredient->name
            ];
        }
        
        return response()->json($result);
    }

    public function toggleFavorite(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $recipeId = $request->input('recipe_id');
        $userId = Auth::id();

        $existingFavorite = Fav::where('id_user', $userId)
            ->where('id_recette', $recipeId)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Fav::create([
                'id_user' => $userId,
                'id_recette' => $recipeId
            ]);
            return response()->json(['status' => 'added']);
        }
    }
}