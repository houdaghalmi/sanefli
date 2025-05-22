@extends('user.base')

@section('content')
<div class="container mt-4">
    <h3>Résultats de recherche</h3>

    @if(isset($recipes) && count($recipes) > 0)
        <div class="row">
            @foreach($recipes as $recipe)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($recipe['image'])
                            <img src="{{ asset('storage/' . $recipe['image']) }}" class="card-img-top" alt="{{ $recipe['name'] }}">
                        @else
                            <img src="{{ asset('placeholder.jpg') }}" class="card-img-top" alt="Placeholder">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $recipe['name'] }}</h5>
                            @if(isset($recipe['preparation_time']))
                                <p class="card-text">{{ $recipe['preparation_time'] }} min</p>
                            @endif
                            <p class="card-text">
                                <strong>Catégorie:</strong> {{ $recipe['category']['name'] ?? 'Non spécifiée' }}<br>
                                <strong>Ingrédients:</strong> {{ implode(', ', $recipe['ingredients']->toArray()) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('recette.detail', $recipe['id']) }}" class="btn btn-primary">Voir la recette</a>
                                @auth
                                <button class="btn btn-outline-danger favorite-btn" data-recipe-id="{{ $recipe['id'] }}">
                                    <i class="far fa-heart"></i>
                                </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            Aucune recette ne correspond à votre recherche.
        </div>
    @endif
</div>
@endsection

@section('scripts')
@auth
<script>
$(document).ready(function() {
    $('.favorite-btn').click(function() {
        const recipeId = $(this).data('recipe-id');
        const button = $(this);
        
        $.ajax({
            url: '{{ route("favorites.store") }}',
            method: 'POST',
            data: {
                recette_id: recipeId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.status === 'added') {
                    button.html('<i class="fas fa-heart"></i>');
                    button.removeClass('btn-outline-danger').addClass('btn-danger');
                } else {
                    button.html('<i class="far fa-heart"></i>');
                    button.removeClass('btn-danger').addClass('btn-outline-danger');
                }
            },
            error: function(xhr) {
                alert('Une erreur est survenue');
            }
        });
    });
});
</script>
@endauth
@endsection