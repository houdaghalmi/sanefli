@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card mb-3">
        <img src="{{ asset('storage/' . $recipe->image) }}" class="card-img-top" alt="{{ $recipe->title }}">
        <div class="card-body">
            <h3 class="card-title">{{ $recipe->title }}</h3>
            <p class="card-text">
                <strong>Temps de préparation :</strong> {{ $recipe->preparation_time }} minutes<br>
                <strong>Portions :</strong> {{ $recipe->portions }}
            </p>
            <p class="card-text"><strong>Description :</strong> {{ $recipe->description }}</p>

            <h5>Ingrédients</h5>
            <ul>
                @foreach($recipe->ingredients as $ingredient)
                    <li>{{ $ingredient->name }}</li>
                @endforeach
            </ul>

            <h5>Instructions</h5>
            <ol>
                @foreach($recipe->instructions as $step)
                    <li>{{ $step->text }}</li>
                @endforeach
            </ol>

            <div class="mt-3 d-flex align-items-center">
                <form action="{{ route('favorites.toggle', $recipe->id) }}" method="POST" class="me-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        @if($isFavorite)
                            Retirer des favoris 
                        @else
                            Ajouter aux favoris 
                        @endif
                    </button>
                </form>

                <div>
                    Note :
                    @for($i = 1; $i <= 5; $i++)
                        <span class="text-warning">
                            {{ $i <= $recipe->rating ? '★' : '☆' }}
                        </span>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
