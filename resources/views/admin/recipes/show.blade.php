@extends('admin.base')

@section('title', 'Détails de la recette')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Détails de la recette: {{ $recipe->name }}</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.recipes.edit', $recipe->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('admin.preparations.create', ['id_recette' => $recipe->id]) }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Ajouter une préparation
                </a>
                <a href="{{ route('admin.recipes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Informations générales</h5>
                <table class="table">
                    <tr>
                        <th style="width: 200px">Nom</th>
                        <td>{{ $recipe->name }}</td>
                    </tr>
                    <tr>
                        <th>Catégorie</th>
                        <td>{{ $recipe->category->name }}</td>
                    </tr>
                    <tr>
                        <th>Ingrédients</th>
                        <td>
                            @if($recipe->ingredients->count() > 0)
                                <ul class="mb-0">
                                    @foreach($recipe->ingredients as $ingredient)
                                        <li>{{ $ingredient->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                Aucun ingrédient défini
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                @if($recipe->image)
                <div class="text-center">
                    <img src="{{ asset('storage/'.$recipe->image) }}" 
                         class="img-fluid rounded" 
                         style="max-height: 200px"
                         alt="Image de {{ $recipe->name }}">
                </div>
                @endif
            </div>
        </div>

   

            @forelse($recipe->preparations as $preparation)
            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Préparation </h6>
                </div>
                <div class="card-body">
                    <h6>Étapes:</h6>
                    <ol class="mb-3">
                        @foreach($preparation->etapes as $etape)
                        <li>{{ $etape->description }}</li>
                        @endforeach
                    </ol>
                          <div >
                           <h6>temp de preparation : <span >{{ $preparation->temps_de_preparation }} minutes</span></h6> 
                        
                        <h6>quantity :  <span >{{ $preparation->quantity }}</span> </h6>
                      
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.preparations.edit', $preparation->id) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form action="{{ route('admin.preparations.destroy', $preparation->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette préparation?')">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-info">
                Aucune préparation n'a été définie pour cette recette.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection