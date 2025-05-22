<!DOCTYPE html>
<html lang="en">
<head>
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

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title">{{ $recipe->name }}</h3>
                        <span class="badge bg-primary mb-3">{{ $recipe->category->name }}</span>
                        
                        <p class="text-muted">{{ $recipe->description }}</p>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Créé le</h5>
                                <p>{{ $recipe->created_at->format('d F, Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Dernière mise à jour</h5>
                                <p>{{ $recipe->updated_at->format('d F, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('storage/'.$recipe->image) }}" 
                         alt="{{ $recipe->name }}" 
                         class="card-img-top">
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
</body>
</html>