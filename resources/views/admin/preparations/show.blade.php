@extends('admin.base')

@section('title', 'Détails de la préparation')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Détails de la préparation</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.preparations.edit', $preparation->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('admin.preparations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th style="width: 200px">ID</th>
                        <td>{{ $preparation->id }}</td>
                    </tr>
                    <tr>
                        <th>Recette</th>
                        <td>
                            <a href="{{ route('admin.recipes.show', $preparation->recette->id) }}">
                                {{ $preparation->recette->name }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Ingrédient</th>
                        <td>
                            <a href="{{ route('admin.ingredients.show', $preparation->ingredient->id) }}">
                                {{ $preparation->ingredient->name }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Quantité</th>
                        <td>{{ $preparation->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Temps de préparation</th>
                        <td>{{ $preparation->temps_de_preparation }} minutes</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <h5>Description</h5>
            <div class="card">
                <div class="card-body">
                    {{ $preparation->description }}
                </div>
            </div>
        </div>

        <div class="mt-4">
            <form action="{{ route('admin.preparations.destroy', $preparation->id) }}" 
                  method="POST" 
                  class="d-inline"
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette préparation ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection