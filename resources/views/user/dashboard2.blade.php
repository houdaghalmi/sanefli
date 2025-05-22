@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">ahla bik, {{ Auth::user()->name }} </h2>

    <div class="mb-4">
        <a href="{{ route('recette.search') }}" class="btn btn-primary">🔍 Rechercher des recettes</a>
    </div>

    <h4>Recettes recommandées</h4>
    <div class="row">
        @foreach($suggestedRecipes as $recipe)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/' . $recipe->image) }}" class="card-img-top" alt="{{ $recipe->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $recipe->title }}</h5>
                        <p class="card-text">{{ $recipe->preparation_time }} min</p>
                        <a href="{{ route('recette.detail', $recipe->id) }}" class="btn btn-primary">Voir la recette</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
