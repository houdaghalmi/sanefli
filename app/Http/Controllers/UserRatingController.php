<?php

namespace App\Http\Controllers;

use App\Models\Notation;
use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRatingController extends Controller
{
    /**
     * Store a new rating or update an existing one.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recettes,id',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        // Check if user has already rated this recipe
        $existingRating = Notation::where('id_user', Auth::id())
            ->where('id_recette', $request->recipe_id)
            ->first();

        if ($existingRating) {
            // Update existing rating
            $existingRating->rating = $request->rating;
            $existingRating->save();
            $message = 'Votre note a été mise à jour.';
        } else {
            // Create new rating
            Notation::create([
                'id_user' => Auth::id(),
                'id_recette' => $request->recipe_id,
                'rating' => $request->rating
            ]);
            $message = 'Merci pour votre notation!';
        }

        // Calculate average rating for this recipe
        $avgRating = Notation::where('id_recette', $request->recipe_id)
            ->avg('rating');

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'average_rating' => round($avgRating, 1)
        ]);
    }

    /**
     * Get the current user's rating for a recipe.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserRating(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recettes,id'
        ]);

        $rating = Notation::where('id_user', Auth::id())
            ->where('id_recette', $request->recipe_id)
            ->first();

        return response()->json([
            'has_rated' => $rating ? true : false,
            'rating' => $rating ? $rating->rating : 0
        ]);
    }

    /**
     * Get the average rating for a recipe.
     * 
     * @param  int  $recipeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAverageRating($recipeId)
    {
        $recipe = Recette::findOrFail($recipeId);
        
        $avgRating = Notation::where('id_recette', $recipeId)
            ->avg('rating');
        
        $ratingCount = Notation::where('id_recette', $recipeId)
            ->count();
            
        return response()->json([
            'average_rating' => $avgRating ? round($avgRating, 1) : 0,
            'rating_count' => $ratingCount
        ]);
    }
} 