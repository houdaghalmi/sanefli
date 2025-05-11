<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Preparation;
use App\Models\Ingredient;
use App\Models\Recette;
use Illuminate\Http\Request;

class AdminPreparationController extends Controller
{
    public function index()
    {
        $preparations = Preparation::with(['recette', 'ingredient'])->get();
        return view('admin.preparations.index', compact('preparations'));
    }

    public function create()
    {
        $recettes = Recette::all();
        $ingredients = Ingredient::all();
        return view('admin.preparations.create', compact('recettes', 'ingredients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_recette' => 'required|exists:recettes,id',
            'id_ingredient' => 'required|exists:ingredients,id',
            'quantity' => 'required|string|max:255',
            'temps_de_preparation' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        Preparation::create($request->all());
        return redirect()->route('admin.preparations.index')->with('success', 'Préparation ajoutée.');
    }

    public function edit(Preparation $preparation)
    {
        $recettes = Recette::all();
        $ingredients = Ingredient::all();
        return view('admin.preparations.edit', compact('preparation', 'recettes', 'ingredients'));
    }

    public function update(Request $request, Preparation $preparation)
    {
        $request->validate([
            'id_recette' => 'required|exists:recettes,id',
            'id_ingredient' => 'required|exists:ingredients,id',
            'quantity' => 'required|string|max:255',
            'temps_de_preparation' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $preparation->update($request->all());
        return redirect()->route('admin.preparations.index')->with('success', 'Préparation modifiée.');
    }

    public function destroy(Preparation $preparation)
    {
        $preparation->delete();
        return redirect()->route('admin.preparations.index')->with('success', 'Préparation supprimée.');
    }
}
