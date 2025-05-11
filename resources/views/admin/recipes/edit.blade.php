@extends('admin.base')

@section('title', 'Modifier la recette')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Modifier : {{ $recipe->name }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Champs similaires à create.blade.php mais avec les valeurs existantes -->
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $recipe->name }}" required>
            </div>
            
            <!-- Afficher les ingrédients existants -->
            @foreach($recipe->preparations as $preparation)
                <div class="ingredient-item row mb-2">
                    <!-- Champs pour chaque ingrédient -->
                </div>
            @endforeach
            
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
</div>
@endsection