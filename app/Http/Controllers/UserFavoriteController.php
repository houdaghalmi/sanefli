<?php

namespace App\Http\Controllers;

use App\Models\Fav;
use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFavoriteController extends Controller
{
    public function index()
    {
        $favorites = Fav::where('id_user', Auth::id())
            ->with(['recette.ingredients', 'recette.category'])
            ->paginate(12);
        
        return view('user.favorites.index', compact('favorites'));
    }

    public function create()
    {
        $allRecipes = Recette::whereNotIn('id', function($query) {
            $query->select('id_recette')
                  ->from('favs')
                  ->where('id_user', Auth::id());
        })->get();

        return view('user.favorites.create', compact('allRecipes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recette_id' => 'required|exists:recettes,id'
        ]);

        $existingFavorite = Fav::where('id_user', Auth::id())
            ->where('id_recette', $request->recette_id)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            return response()->json([
                'status' => 'removed', 
                'message' => 'Recette retirée des favoris'
            ]);
        }

        Fav::create([
            'id_user' => Auth::id(),
            'id_recette' => $request->recette_id
        ]);

        return response()->json([
            'status' => 'added', 
            'message' => 'Recette ajoutée aux favoris'
        ]);
    }

    public function check(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recettes,id'
        ]);
        
        $isFavorite = Fav::where('id_user', Auth::id())
            ->where('id_recette', $request->recipe_id)
            ->exists();
            
        return response()->json([
            'is_favorite' => $isFavorite
        ]);
    }

    public function destroy($id)
    {
        $favorite = Fav::where('id_user', Auth::id())
            ->where('id_recette', $id)
            ->firstOrFail();
        
        $favorite->delete();
        
        return response()->json([
            'message' => 'Recette retirée des favoris'
        ]);
    }
}