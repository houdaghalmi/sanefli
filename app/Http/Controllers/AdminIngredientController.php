<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AdminIngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('admin.ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('admin.ingredients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Store the original image
            $path = $file->storeAs('ingredients', $filename, 'public');
            $validated['image'] = $path;
        }

        Ingredient::create($validated);

        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Ingrédient ajouté avec succès');
    }

    public function edit(Ingredient $ingredient)
    {
        return view('admin.ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($ingredient->image) {
                Storage::disk('public')->delete($ingredient->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Store the new image
            $path = $file->storeAs('ingredients', $filename, 'public');
            $validated['image'] = $path;
        }

        $ingredient->update($validated);

        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Ingrédient modifié avec succès');
    }

    public function destroy(Ingredient $ingredient)
    {
        if ($ingredient->image) {
            Storage::disk('public')->delete($ingredient->image);
        }
        
        $ingredient->delete();
        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Ingrédient supprimé.');
    }
}
