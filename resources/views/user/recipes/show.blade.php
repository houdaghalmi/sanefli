@extends('user.base')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                @if($recipe->image)
                    <img src="{{ asset('storage/' . $recipe->image) }}" class="card-img-top img-fluid recipe-main-image" alt="{{ $recipe->name }}">
                @else
                    <img src="{{ asset('images/placeholder.jpg') }}" class="card-img-top img-fluid recipe-main-image" alt="Placeholder">
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h1 class="card-title mb-3">{{ $recipe->name }}</h1>
                        @auth
                        <button class="btn btn-outline-danger favorite-btn" data-recipe-id="{{ $recipe->id }}">
                            <i class="{{ $recipe->isFavoritedBy(Auth::id()) ? 'fas' : 'far' }} fa-heart"></i>
                        </button>
                        @endauth
                    </div>
                    
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <span class="badge bg-primary">
                            <i class="fas fa-clock me-1"></i> {{ $recipe->getPreparationTime() }} min
                        </span>
                        <span class="badge bg-success">
                            <i class="fas fa-utensils me-1"></i> {{ $recipe->category->name ?? 'Non spécifiée' }}
                        </span>
                        @if($recipe->preparation)
                            <span class="badge bg-info">
                                <i class="fas fa-list-ol me-1"></i> {{ $recipe->preparation->nombre_etapes }} étapes
                            </span>
                        @endif
                    </div>

                    @if($recipe->description)
                    <div class="mb-4">
                        <h4 class="border-bottom pb-2">Description</h4>
                        <p class="card-text">{{ $recipe->description }}</p>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h4 class="border-bottom pb-2">Ingrédients</h4>
                            <ul class="list-group list-group-flush">
                                @foreach($recipe->ingredients as $ingredient)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="d-flex align-items-center">
                                            @if($ingredient->image)
                                                <img src="{{ asset('storage/' . $ingredient->image) }}" 
                                                     class="rounded me-3 ingredient-image" 
                                                     alt="{{ $ingredient->name }}">
                                            @endif
                                            <div>
                                                <div>{{ $ingredient->name }}</div>
                                                @if($ingredient->pivot->quantity)
                                                    <small class="text-muted">{{ $ingredient->pivot->quantity }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="col-md-6 mb-4">
                            <h4 class="border-bottom pb-2">Instructions de préparation</h4>
                            <div class="steps">
                                @if($recipe->preparation && $recipe->preparation->etapes->count() > 0)
                                    @foreach($recipe->preparation->etapes as $etape)
                                        <div class="step mb-4">
                                            <div class="d-flex">
                                                <span class="step-number">{{ $etape->numero }}</span>
                                                <div class="step-content">
                                                    <p class="mb-2">{{ $etape->description }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info">Aucune instruction disponible</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Détails de la recette</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-clock me-2"></i>Temps de préparation</span>
                            <span class="badge bg-primary rounded-pill">{{ $recipe->getPreparationTime() }} min</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-fire me-2"></i>Difficulté</span>
                            <span class="badge bg-info rounded-pill">{{ $recipe->difficulty ?? 'Non spécifiée' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-utensils me-2"></i>Portions</span>
                            <span class="badge bg-success rounded-pill">
                                @if($recipe->preparation){{ $recipe->preparation->quantity }}@endif</span>
                        </li>
                        @if($recipe->preparation)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-list-ol me-2"></i>Nombre d'étapes</span>
                            <span class="badge bg-secondary rounded-pill">{{ $recipe->preparation->nombre_etapes }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            @if(count($similarRecipes) > 0)
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Recettes similaires</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($similarRecipes as $similar)
                                <a href="{{ route('user.recipe.show', $similar->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center">
                                        @if($similar->image)
                                            <img src="{{ asset('storage/' . $similar->image) }}" 
                                                 class="rounded me-3 similar-recipe-image" 
                                                 alt="{{ $similar->name }}">
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $similar->name }}</h6>
                                            <small class="text-muted">{{ $similar->getPreparationTime() }} min</small>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .recipe-main-image {
        max-height: 400px;
        object-fit: cover;
        width: 100%;
    }
    
    .ingredient-image {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }
    
    .similar-recipe-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }
    
    .step-number {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #0d6efd;
        color: white;
        border-radius: 50%;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .step-content {
        flex-grow: 1;
    }
</style>
@endsection

@section('scripts')
@auth
<script>
$(document).ready(function() {
    $('.favorite-btn').click(function() {
        const recipeId = $(this).data('recipe-id');
        const button = $(this);
        const icon = button.find('i');
        
        $.ajax({
            url: '{{ route("user.favorites.store") }}',
            method: 'POST',
            data: {
                recette_id: recipeId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.status === 'added') {
                    icon.removeClass('far').addClass('fas');
                    button.removeClass('btn-outline-danger').addClass('btn-danger');
                } else {
                    icon.removeClass('fas').addClass('far');
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