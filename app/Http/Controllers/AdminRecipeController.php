<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Recette;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminRecipeController extends Controller
{
    public function index()
    {
        $recipes = Recette::with('category')->get();
        return view('admin.recipes.index', compact('recipes'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.recipes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_category' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Store the image
            $path = $file->storeAs('recipes', $filename, 'public');
            $validated['image'] = $path;
        }

        Recette::create($validated);
        return redirect()->route('admin.recipes.index')->with('success', 'Recette ajoutée.');
    }

    public function edit(Recette $recette)
    {
        $categories = Category::all();
        return view('admin.recipes.edit', compact('recette', 'categories'));
    }

    public function update(Request $request, Recette $recette)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_category' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($recette->image) {
                Storage::disk('public')->delete($recette->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Store the new image
            $path = $file->storeAs('recipes', $filename, 'public');
            $validated['image'] = $path;
        }

        $recette->update($validated);
        return redirect()->route('admin.recipes.index')->with('success', 'Recette modifiée.');
    }

    public function destroy(Recette $recette)
    {
        if ($recette->image) {
            Storage::disk('public')->delete($recette->image);
        }
        
        $recette->delete();
        return redirect()->route('admin.recipes.index')->with('success', 'Recette supprimée.');
    }
}
