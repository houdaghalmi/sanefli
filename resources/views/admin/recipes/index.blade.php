@extends('admin.base')

@section('title', 'Gestion des recettes')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Liste des recettes</h4>
            <a href="{{ route('admin.recipes.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Ajouter une recette
            </a>
        </div>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recipes as $recipe)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/'.$recipe->image) }}" alt="{{ $recipe->name }}" width="50" class="img-thumbnail">
                        </td>
                        <td>{{ $recipe->name }}</td>
                        <td>{{ $recipe->category->name }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.recipes.show', $recipe->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye">view</i>
                                </a>
                                <a href="{{ route('admin.recipes.edit', $recipe->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit">edit</i>
                                </a>
                                <form action="{{ route('admin.recipes.destroy', $recipe->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">
                                        <i class="fas fa-trash">delete</i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($recipes->isEmpty())
            <div class="alert alert-info">Aucune recette trouvée</div>
        @endif
        
    </div>
</div>
@endsection