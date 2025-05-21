<?php

namespace App\Http\Controllers;

use App\Models\Etape;
use App\Models\Preparation;
use Illuminate\Http\Request;

class AdminEtapeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etapes = Etape::with('preparation.recette')->get();
        return view('admin.etapes.index', compact('etapes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $preparations = Preparation::with('recette')->get();
        return view('admin.etapes.create', compact('preparations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'preparation_id' => 'required|exists:preparations,id',
            'numero_etape' => 'required|integer|min:1',
            'description' => 'required|string'
        ]);

        Etape::create($validated);

        return redirect()->route('admin.etapes.index')
            ->with('success', 'Étape créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Etape $etape)
    {
        $etape->load('preparation.recette');
        return view('admin.etapes.show', compact('etape'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etape $etape)
    {
        $preparations = Preparation::with('recette')->get();
        return view('admin.etapes.edit', compact('etape', 'preparations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etape $etape)
    {
        $validated = $request->validate([
            'preparation_id' => 'required|exists:preparations,id',
            'numero_etape' => 'required|integer|min:1',
            'description' => 'required|string'
        ]);

        $etape->update($validated);

        return redirect()->route('admin.etapes.index')
            ->with('success', 'Étape mise à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etape $etape)
    {
        $etape->delete();
        return redirect()->route('admin.etapes.index')
            ->with('success', 'Étape supprimée avec succès');
    }
}
