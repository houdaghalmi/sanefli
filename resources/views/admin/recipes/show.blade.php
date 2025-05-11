@extends('admin.base')

@section('title', $recipe->name)

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4>Détails de la recette</h4>
            <div>
                <a href="{{ route('admin.recipes.edit', $recipe->id) }}" class="btn btn-sm btn-warning">Éditer</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('storage/'.$recipe->image) }}" class="img-fluid rounded" alt="{{ $recipe->name }}">
            </div>
            <div class="col-md-8">
                <h3>{{ $recipe->name }}</h3>
                <p><strong>Catégorie:</strong> {{ $recipe->category->name }}</p>
                <p><strong>Temps de préparation:</strong> {{ $recipe->prep_time }} minutes</p>
                
                <h5 class="mt-4">Ingrédients:</h5>
                <ul class="list-group">
                    @foreach($recipe->preparations as $preparation)
                        <li class="list-group-item">
                            {{ $preparation->ingredient->name }} - {{ $preparation->quantity }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        
  
    </div>
</div>
@endsection