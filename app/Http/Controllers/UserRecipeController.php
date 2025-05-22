<?php

namespace App\Http\Controllers;

use App\Models\Recette;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Models\Fav;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserRecipeController extends Controller
{
    public function index()
    {
        $recipes = Recette::with(['ingredients', 'category'])
            ->paginate(12);
            
        return view('user.recipes.index', compact('recipes'));
    }

    public function show(string $id)
    {
        $recipe = Recette::with(['ingredients', 'category'])
            ->findOrFail($id);
        
        // Get similar recipes (same category)
        $similarRecipes = Recette::where('id_category', $recipe->id_category)
            ->where('id', '!=', $recipe->id)
            ->limit(3)
            ->get();

        return view('user.recipes.show', [
            'recipe' => $recipe,
            'similarRecipes' => $similarRecipes
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('ingredient');

        if (empty($query)) {
            return redirect()->route('user.recipes.index');
        }

        $recipes = Recette::whereHas('ingredients', function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->orWhere('name', 'like', '%' . $query . '%')
            ->with(['ingredients', 'category'])
            ->paginate(12);

        return view('user.recipes.index', compact('recipes', 'query'));
    }

    /**
     * Get ingredients for autocomplete.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
} 