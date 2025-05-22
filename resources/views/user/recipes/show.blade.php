@extends('user.base')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                @if($recipe->image)
                    <img src="{{ asset('storage/' . $recipe->image) }}" class="card-img-top" alt="{{ $recipe->name }}">
                @else
                    <img src="{{ asset('placeholder.jpg') }}" class="card-img-top" alt="Placeholder">
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h1 class="card-title mb-3">{{ $recipe->name }}</h1>
                        @auth
                        <button class="btn btn-outline-danger favorite-btn" data-recipe-id="{{ $recipe->id }}">
                            <i class="{{ Auth::user()->hasFavorited($recipe->id) ? 'fas' : 'far' }} fa-heart"></i>
                        </button>
                        @endauth
                    </div>
                    
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <span class="badge bg-primary">
                            <i class="fas fa-clock me-1"></i> {{ $recipe->preparation_time }} min
                        </span>
                        <span class="badge bg-success">
                            <i class="fas fa-utensils me-1"></i> {{ $recipe->category->name ?? 'Non spécifiée' }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <h4 class="border-bottom pb-2">Description</h4>
                        <p class="card-text">{{ $recipe->description ?? 'Aucune description disponible' }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h4 class="border-bottom pb-2">Ingrédients</h4>
                            <ul class="list-group list-group-flush">
                                @foreach($recipe->ingredients as $ingredient)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $ingredient->name }}
                                        @if($ingredient->pivot->quantity)
                                            <span class="badge bg-primary rounded-pill">
                                                {{ $ingredient->pivot->quantity }}
                                            </span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="col-md-6 mb-4">
                            <h4 class="border-bottom pb-2">Instructions</h4>
                            <div class="steps">
                                @if($recipe->steps)
                                    @foreach(explode("\n", $recipe->steps) as $step)
                                        @if(trim($step))
                                            <div class="step mb-2 d-flex">
                                                <span class="badge bg-secondary me-2">{{ $loop->iteration }}</span>
                                                <span>{{ $step }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <p>Aucune instruction disponible</p>
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
                    <h5 class="mb-0">Informations</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="fas fa-user-clock me-2"></i>Temps de préparation</span>
                            <span>{{ $recipe->preparation_time }} minutes</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="fas fa-fire me-2"></i>Difficulté</span>
                            <span>{{ $recipe->difficulty ?? 'Non spécifiée' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="fas fa-utensils me-2"></i>Portions</span>
                            <span>{{ $recipe->servings ?? 'Non spécifiée' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

          
        </div>
    </div>
</div>
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