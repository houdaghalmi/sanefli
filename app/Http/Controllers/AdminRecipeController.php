<?php

namespace App\Http\Controllers;

use App\Models\Recette;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminRecipeController extends Controller
{
    public function index()
    {
        // Pagination de 6 recettes par page
        $recipes = Recette::with(['category', 'ingredients'])->paginate(6);
        return view('admin.recipes.index', compact('recipes'));
    }

    public function create()
    {
        $categories = Category::all();
        $ingredients = Ingredient::all();
        return view('admin.recipes.create', compact('categories', 'ingredients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_category' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'ingredients' => 'required|array',
            'ingredients.*' => 'exists:ingredients,id'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('recipes', $filename, 'public');
            $validated['image'] = $path;
        }

        $recipe = Recette::create($validated);
        $recipe->ingredients()->sync($request->ingredients);

        return redirect()->route('admin.recipes.index')->with('success', 'Recette ajoutée.');
    }

    public function show(Recette $recipe)
    {
        $recipe->load([
            'category',
            'ingredients',
            'preparations' => function ($query) {
                $query->with(['etapes' => function ($q) {
                    $q->orderBy('numero');
                }]);
            }
        ]);

        return view('admin.recipes.show', compact('recipe'));
    }

    public function edit(Recette $recipe)
    {
        $categories = Category::all();
        $ingredients = Ingredient::all();
        $recipe->load('ingredients');
        return view('admin.recipes.edit', compact('recipe', 'categories', 'ingredients'));
    }

    public function update(Request $request, Recette $recipe)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_category' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ingredients' => 'required|array',
            'ingredients.*' => 'exists:ingredients,id'
        ]);

        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('recipes', $filename, 'public');
            $validated['image'] = $path;
        }

        $recipe->update($validated);
        $recipe->ingredients()->sync($request->ingredients);

        return redirect()->route('admin.recipes.index')->with('success', 'Recette modifiée.');
    }

    public function destroy(Recette $recipe)
    {
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->ingredients()->detach();
        $recipe->delete();
        return redirect()->route('admin.recipes.index')->with('success', 'Recette supprimée.');
    }
}
