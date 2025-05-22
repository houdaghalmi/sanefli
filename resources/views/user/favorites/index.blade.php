@extends('user.base')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
<style>
    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 9999;
    }
    .ui-menu-item {
        padding: 5px;
        cursor: pointer;
    }
    .ui-menu-item:hover {
        background-color: #f8f9fa;
    }
    .ui-autocomplete-category {
        font-weight: bold;
        padding: .2em .4em;
        margin: .8em 0 .2em;
        line-height: 1.5;
    }
    #ingredient-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 5px;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Mes Favoris</h3>

    <!-- Ingredients Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <label for="ingredient-search" class="form-label">Filtrer par ingrédients</label>
                    <div class="input-group mb-2">
                        <input type="text" id="ingredient-search" class="form-control" 
                               placeholder="Ex: tomate, oignon, poulet">
                        <button id="search-btn" class="btn btn-primary">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                    <div id="selected-ingredients" class="mb-2"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Filtres rapides</label>
                    <div class="d-flex flex-wrap" id="popular-ingredients">
                        <!-- Will be populated by JavaScript -->
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loading-indicator" class="text-center d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
    </div>

    <div id="favorites-container">
        @if($favorites->count() > 0)
            <div class="row" id="favorites-list">
                @foreach($favorites as $favorite)
                    <div class="col-md-4 mb-4 favorite-item">
                        <div class="card h-100 shadow-sm">
                            @if($favorite->recette->image)
                                <img src="{{ asset('storage/' . $favorite->recette->image) }}" class="card-img-top" alt="{{ $favorite->recette->name }}">
                            @else
                                <img src="{{ asset('placeholder.jpg') }}" class="card-img-top" alt="Placeholder">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $favorite->recette->name }}</h5>
                                <p class="card-text">
                                    <small class="text-muted">{{ $favorite->recette->preparation_time }} min</small><br>
                                    <strong>Catégorie:</strong> {{ $favorite->recette->category->name ?? 'Non spécifiée' }}
                                </p>
                                <p class="card-text">
                                    <strong>Ingrédients:</strong><br>
                                    <span class="ingredients-list" data-ingredients="{{ implode(',', $favorite->recette->ingredients->pluck('name')->toArray()) }}">
                                        @foreach($favorite->recette->ingredients as $ingredient)
                                            <span class="badge bg-secondary me-1 mb-1 ingredient-badge" data-name="{{ $ingredient->name }}">
                                                {{ $ingredient->name }}
                                            </span>
                                        @endforeach
                                    </span>
                                </p>
                              
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $favorites->links() }}
            </div>
        @else
            <div class="alert alert-info">
                Vous n'avez aucune recette favorite pour le moment.
            </div>
        @endif
    </div>
</div>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
$(document).ready(function() {
    // Array to store selected ingredients for filtering
    let selectedIngredients = [];
    
    // Setup autocomplete
    $("#ingredient-search").autocomplete({
        source: function(request, response) {
            // Extract the last term from a comma-separated list
            const term = extractLastTerm(request.term);
            
            if (term.length < 2) {
                return;
            }
            
            $.ajax({
                url: "{{ route('user.ingredients.autocomplete') }}",
                data: {
                    query: term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 2,
        focus: function() {
            // Prevent value inserted on focus
            return false;
        },
        select: function(event, ui) {
            const terms = splitTerms(this.value);
            // Remove the current input
            terms.pop();
            // Add the selected item
            terms.push(ui.item.value);
            // Add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join(", ");
            return false;
        },
        search: function() {
            // Custom minLength
            const term = extractLastTerm(this.value);
            if (term.length < 2) {
                return false;
            }
            return true;
        }
    });
    
    // Extract the last term from a comma-separated string
    function extractLastTerm(term) {
        return splitTerms(term).pop();
    }
    
    // Split terms by comma
    function splitTerms(val) {
        return val.split(/,\s*/);
    }
    
    // Load popular ingredients (from existing recipes)
    loadPopularIngredients();
    
    // Click event for search button
    $('#search-btn').click(function() {
        const ingredientInput = $('#ingredient-search').val().trim();
        if (ingredientInput) {
            // Split by comma and add each ingredient
            const ingredients = splitTerms(ingredientInput).filter(item => item.trim() !== "");
            ingredients.forEach(ingredient => {
                if (ingredient && !selectedIngredients.includes(ingredient.toLowerCase())) {
                    addIngredient(ingredient);
                }
            });
            $('#ingredient-search').val('');
        }
        filterRecipes();
    });
    
    // Allow pressing Enter in the search box
    $('#ingredient-search').keypress(function(e) {
        if (e.which === 13) {
            $('#search-btn').click();
            return false;
        }
    });
    
    // Remove favorite functionality
    $('.remove-favorite').click(function() {
        const recipeId = $(this).data('recipe-id');
        const button = $(this);
        const card = button.closest('.col-md-4');
        
        $.ajax({
            url: '{{ route("user.favorites.destroy", "") }}/' + recipeId,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                card.fadeOut(300, function() {
                    $(this).remove();
                    if($('.col-md-4').length === 0) {
                        location.reload();
                    }
                });
            },
            error: function(xhr) {
                alert('Une erreur est survenue');
            }
        });
    });
    
    // Function to load popular ingredients from existing favorites
    function loadPopularIngredients() {
        const allIngredients = {};
        
        // Collect all ingredients from the page
        $('.ingredients-list').each(function() {
            const ingredients = $(this).data('ingredients').split(',');
            ingredients.forEach(ing => {
                if (ing) {
                    allIngredients[ing] = (allIngredients[ing] || 0) + 1;
                }
            });
        });
        
        // Sort by frequency
        const sortedIngredients = Object.keys(allIngredients).sort((a, b) => {
            return allIngredients[b] - allIngredients[a];
        });
        
        // Take the top 10
        const popularIngredients = sortedIngredients.slice(0, 10);
        
        // Populate the quick filters
        const container = $('#popular-ingredients');
        container.empty();
        
        popularIngredients.forEach(ing => {
            const badge = $('<span class="badge bg-secondary me-1 mb-1 popular-ingredient" style="cursor: pointer;">' + ing + '</span>');
            badge.click(function() {
                if (!selectedIngredients.includes(ing.toLowerCase())) {
                    addIngredient(ing);
                    filterRecipes();
                }
            });
            container.append(badge);
        });
    }
    
    // Function to add an ingredient to the filter
    function addIngredient(name) {
        const normalizedName = name.toLowerCase();
        selectedIngredients.push(normalizedName);
        
        const badge = $('<span class="badge bg-primary me-1 mb-1">' + name + ' <i class="fas fa-times"></i></span>');
        badge.find('i').click(function() {
            badge.remove();
            selectedIngredients = selectedIngredients.filter(ing => ing !== normalizedName);
            filterRecipes();
        });
        
        $('#selected-ingredients').append(badge);
    }
    
    // Function to filter recipes based on selected ingredients
    function filterRecipes() {
        // Show loading indicator
        $('#loading-indicator').removeClass('d-none');
        
        if (selectedIngredients.length === 0) {
            // If no filters, show all recipes
            $('.favorite-item').show();
            $('#loading-indicator').addClass('d-none');
            return;
        }
        
        // Hide all recipes initially
        $('.favorite-item').hide();
        
        // Check each recipe
        $('.favorite-item').each(function() {
            const card = $(this);
            const ingredientsList = card.find('.ingredients-list').data('ingredients').toLowerCase();
            const ingredientsArray = ingredientsList.split(',');
            
            // Check if all selected ingredients are in this recipe
            const hasAllIngredients = selectedIngredients.every(ing => 
                ingredientsArray.some(recipeIng => recipeIng.trim().includes(ing))
            );
            
            if (hasAllIngredients) {
                // Highlight matching ingredients
                card.find('.ingredient-badge').each(function() {
                    const badge = $(this);
                    const ingName = badge.data('name').toLowerCase();
                    
                    if (selectedIngredients.some(selected => ingName.includes(selected))) {
                        badge.removeClass('bg-secondary').addClass('bg-success');
                    } else {
                        badge.removeClass('bg-success').addClass('bg-secondary');
                    }
                });
                
                // Show this recipe with animation
                card.fadeIn(300);
            }
        });
        
        // Hide loading indicator
        setTimeout(() => {
            $('#loading-indicator').addClass('d-none');
            
            // If no results, show message
            if ($('.favorite-item:visible').length === 0) {
                if ($('#no-results-message').length === 0) {
                    $('#favorites-list').after(
                        '<div id="no-results-message" class="alert alert-info">' +
                        'Aucune recette ne contient tous ces ingrédients.' +
                        '</div>'
                    );
                }
            } else {
                $('#no-results-message').remove();
            }
        }, 300);
    }
});
</script>
@endsection