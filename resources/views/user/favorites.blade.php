@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Mes recettes favorites</h3>

    @if(count($favorites) > 0)
        <div class="row">
            @foreach($favorites as $recipe)
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
    @else
        <p>Vous n'avez pas encore ajouté de recettes aux favoris.</p>
    @endif
</div>
@endsection
