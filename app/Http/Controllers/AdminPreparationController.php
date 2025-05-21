<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Preparation;
use App\Models\Etape;
use App\Models\Recette;
use Illuminate\Http\Request;

class AdminPreparationController extends Controller
{
    public function index()
    {
        $preparations = Preparation::with(['recette', 'etapes'])->get();
        return view('admin.preparations.index', compact('preparations'));
    }

    public function create()
    {
        $recettes = Recette::all();
        return view('admin.preparations.create', compact('recettes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_recette' => 'required|exists:recettes,id',
            'quantity' => 'required|string',
            'temps_de_preparation' => 'required|integer|min:1',
            'nombre_etapes' => 'required|integer|min:1',
            'etapes' => 'required|array|size:' . $request->nombre_etapes,
            'etapes.*.description' => 'required|string'
        ]);

        $preparation = Preparation::create([
            'id_recette' => $validated['id_recette'],
            'quantity' => $validated['quantity'],
            'temps_de_preparation' => $validated['temps_de_preparation'],
            'nombre_etapes' => $validated['nombre_etapes']
        ]);

        foreach ($validated['etapes'] as $index => $etape) {
            $preparation->etapes()->create([
                'numero' => $index + 1,
                'description' => $etape['description']
            ]);
        }

        return redirect()->route('admin.preparations.index')
            ->with('success', 'Préparation créée avec succès');
    }

  public function show(Preparation $preparation)
{
    $preparation->load([
        'recette.category',
        'etapes' => function($query) {
            $query->orderBy('numero');
        }
    ]);
    
    return view('admin.preparations.show', compact('preparation'));
}

    public function edit(Preparation $preparation)
    {
        $recettes = Recette::all();
        $preparation->load('etapes');
        return view('admin.preparations.edit', compact('preparation', 'recettes'));
    }

    public function update(Request $request, Preparation $preparation)
    {
        $validated = $request->validate([
            'id_recette' => 'required|exists:recettes,id',
            'quantity' => 'required|string',
            'temps_de_preparation' => 'required|integer|min:1',
            'nombre_etapes' => 'required|integer|min:1',
            'etapes' => 'required|array|size:' . $request->nombre_etapes,
            'etapes.*.description' => 'required|string'
        ]);

        $preparation->update([
            'id_recette' => $validated['id_recette'],
            'quantity' => $validated['quantity'],
            'temps_de_preparation' => $validated['temps_de_preparation'],
            'nombre_etapes' => $validated['nombre_etapes']
        ]);

        // Delete existing steps
        $preparation->etapes()->delete();

        // Create new steps
        foreach ($validated['etapes'] as $index => $etape) {
            $preparation->etapes()->create([
                'numero' => $index + 1,
                'description' => $etape['description']
            ]);
        }

        return redirect()->route('admin.preparations.index')
            ->with('success', 'Préparation mise à jour avec succès');
    }

    public function destroy(Preparation $preparation)
    {
        $preparation->delete();
        return redirect()->route('admin.preparations.index')
            ->with('success', 'Préparation supprimée avec succès');
    }
}