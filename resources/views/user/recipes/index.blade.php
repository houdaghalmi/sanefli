@extends('user.base')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
<style>
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 9999;
        border: 1px solid #ddd;
        border-radius: 0 0 4px 4px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        background-color: white;
        width: auto !important;
        min-width: 300px;
    }
    .ui-menu-item {
        padding: 2px;
        cursor: pointer;
    }
    .ui-menu-item:hover {
        background-color: #f8f9fa;
    }
    .autocomplete-item {
        padding: 8px 12px;
        font-size: 14px;
        border-bottom: 1px solid #f0f0f0;
    }
    .autocomplete-item:hover {
        background-color: #e9f5ff;
    }
    .autocomplete-category {
        font-weight: bold;
        padding: 8px 12px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        color: #495057;
    }
    .recipe-tags {
        margin-top: 8px;
    }
    .badge-ingredient {
        cursor: pointer;
    }
    #selected-ingredients .badge {
        cursor: pointer;
    }
    #loading-indicator {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
    }
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        z-index: 999;
    }
    .ui-state-active, 
    .ui-widget-content .ui-state-active {
        border: 1px solid #007bff;
        background: #e9f5ff;
        color: #333;
    }
    .search-container {
        position: relative;
    }
    .search-icon {
        position: absolute;
        right: 50px;
        top: 10px;
        color: #aaa;
        cursor: pointer;
        transition: color 0.2s;
    }
    .search-icon:hover {
        color: #007bff;
    }
    #ingredient-search {
        border-color: #ced4da;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    #ingredient-search:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .typing #ingredient-search {
        border-color: #80bdff;
    }
    .ui-autocomplete-up {
        max-height: 300px;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 9999;
        border: 1px solid #ddd;
        border-radius: 4px 4px 0 0;
        box-shadow: 0 -4px 8px rgba(0,0,0,0.1);
    }
    /* Category filter styles */
    .category-filter-container {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .category-filter-title {
        font-weight: 600;
        margin-bottom: 15px;
        color: #495057;
    }
    .form-check-label {
        cursor: pointer;
        user-select: none;
    }
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .category-badge {
        cursor: pointer;
        margin-right: 5px;
        margin-bottom: 5px;
    }
    
    /* Rating styles */
    .recipe-rating {
        font-size: 0.9rem;
    }

    .rating-stars {
        color: #ffc107;
    }

    .user-rating {
        cursor: pointer;
    }

    .rating-star {
        transition: all 0.2s ease;
    }

    .rating-star:hover {
        transform: scale(1.2);
    }

    .text-warning {
        color: #ffc107 !important;
    }

    .text-secondary {
        color: #6c757d !important;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3 class="mb-0">Nos Recettes</h3>
        <button id="clear-filters" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-times me-1"></i> Réinitialiser les filtres
        </button>
    </div>

    <!-- Category Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Filtrer par catégorie</h5>
            <div class="row">
                @foreach(App\Models\Category::all() as $category)
                <div class="col-md-3 col-6 mb-2">
                    <div class="form-check">
                        <input class="form-check-input category-filter" 
                               type="checkbox" 
                               value="{{ $category->id }}" 
                               id="category-{{ $category->id }}">
                        <label class="form-check-label" for="category-{{ $category->id }}">
                            {{ $category->name }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Ingredients Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <label for="ingredient-search" class="form-label">Filtrer par ingrédients</label>
                    <div class="input-group mb-2 search-container">
                        <input type="text" id="ingredient-search" class="form-control" 
                               placeholder="Entrez des ingrédients (séparés par des virgules)...">
                        <i class="fas fa-list search-icon" id="show-all-ingredients"></i>
                        <button id="search-btn" class="btn btn-primary">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                    <div id="selected-ingredients" class="mb-2"></div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Filtres rapides</label>
                    <div class="d-flex flex-wrap" id="popular-ingredients">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loading-indicator" class="d-none">
        <div class="overlay"></div>
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
    </div>

    <div id="recipes-container">
        @if($recipes->count() > 0)
            <div class="row" id="recipes-list">
                @foreach($recipes as $recipe)
                    <div class="col-md-4 mb-4 recipe-item">
                        <div class="card h-100 shadow-sm" data-category-id="{{ $recipe->category->id ?? '' }}">
                            @if($recipe->image)
                                <img src="{{ asset('storage/' . $recipe->image) }}" class="card-img-top" alt="{{ $recipe->name }}">
                            @else
                                <img src="{{ asset('placeholder.jpg') }}" class="card-img-top" alt="Placeholder">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $recipe->name }}</h5>
                                <p class="card-text">
                                    <small class="text-muted">{{ $recipe->preparation_time }} min</small><br>
                                    <strong>Catégorie:</strong> {{ $recipe->category->name ?? 'Non spécifiée' }}
                                </p>
                                
                                <!-- Add this rating section -->
                                <div class="recipe-rating mb-2">
                                    <div class="stars" data-recipe-id="{{ $recipe->id }}">
                                        @php
                                            $averageRating = $recipe->notations->avg('rating');
                                            $userRating = $recipe->notations->where('user_id', auth()->id())->first()?->rating;
                                        @endphp
                                        <div class="rating-stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $averageRating ? 'text-warning' : 'text-secondary' }}"></i>
                                            @endfor
                                            <span class="ms-2 text-muted">({{ number_format($averageRating, 1) }})</span>
                                        </div>
                                        @auth
                                        <div class="user-rating mt-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="far fa-star rating-star {{ $i <= $userRating ? 'fas text-warning' : '' }}" 
                                                   data-value="{{ $i }}" 
                                                   data-recipe-id="{{ $recipe->id }}"></i>
                                            @endfor
                                        </div>
                                        @endauth
                                    </div>
                                </div>
                                
                                @if($recipe->ingredients->count() > 0)
                                    <p class="card-text">
                                        <strong>Ingrédients:</strong><br>
                                        <div class="recipe-tags">
                                            <span class="ingredients-list" data-ingredients="{{ implode(',', $recipe->ingredients->pluck('name')->toArray()) }}">
                                                @foreach($recipe->ingredients as $ingredient)
                                                    <span class="badge bg-secondary me-1 mb-1 ingredient-badge" data-name="{{ $ingredient->name }}">
                                                        {{ $ingredient->name }}
                                                    </span>
                                                @endforeach
                                            </span>
                                        </div>
                                    </p>
                                @endif
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('user.recipe.show', $recipe->id) }}" class="btn btn-primary">Voir</a>
                                    @auth
                                    <button class="btn btn-outline-danger favorite-btn" data-recipe-id="{{ $recipe->id }}">
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
                Aucune recette disponible pour le moment.
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    console.log("Document ready, initializing recipe filtering");
    
    // Arrays to store selected filters
    let selectedIngredients = [];
    let selectedCategories = [];
    
    // Setup autocomplete
    $("#ingredient-search").autocomplete({
        source: function(request, response) {
            const lastTerm = extractLastTerm(request.term);
            
            $.ajax({
                url: "{{ route('user.ingredients.autocomplete') }}",
                data: {
                    query: lastTerm
                },
                success: function(data) {
                    let result = [];
                    let currentCategory = '';
                    
                    for (let i = 0; i < data.length; i++) {
                        if (data[i].category !== undefined) {
                            if (currentCategory !== data[i].category) {
                                currentCategory = data[i].category;
                                result.push({
                                    label: currentCategory,
                                    value: '',
                                    isCategory: true
                                });
                            }
                        } else {
                            result.push(data[i]);
                        }
                    }
                    
                    response(result);
                },
                error: function() {
                    response([]);
                }
            });
        },
        minLength: 0,
        delay: 0,
        focus: function() {
            return false;
        },
        select: function(event, ui) {
            if (ui.item.isCategory) {
                return false;
            }
            
            const terms = splitTerms(this.value);
            terms.pop();
            terms.push(ui.item.value);
            terms.push("");
            this.value = terms.join(", ");
            return false;
        }
    }).data("ui-autocomplete")._renderItem = function(ul, item) {
        if (item.isCategory) {
            return $("<li>")
                .addClass("autocomplete-category")
                .append(item.label)
                .appendTo(ul);
        } else {
            return $("<li>")
                .append("<div class='autocomplete-item'>" + item.label + "</div>")
                .appendTo(ul);
        }
    };
    
    // Show all ingredients when clicking or focusing on the search field
    $("#ingredient-search").on("focus click", function() {
        $(this).autocomplete("search", "");
    });
    
    // Show all ingredients when clicking the list icon
    $("#show-all-ingredients").on("click", function() {
        $("#ingredient-search").focus();
    });
    
    // Update suggestions immediately as user types
    $("#ingredient-search").on("keyup", function() {
        $(this).autocomplete("search", $(this).val());
        $('.search-container').addClass('typing');
        clearTimeout(window.typingTimer);
        window.typingTimer = setTimeout(function() {
            $('.search-container').removeClass('typing');
        }, 1000);
    });
    
    // Reset typing class when focus is lost
    $("#ingredient-search").on("blur", function() {
        clearTimeout(window.typingTimer);
        $('.search-container').removeClass('typing');
    });
    
    // Load popular ingredients (from existing recipes)
    loadPopularIngredients();
    
    // Click event for search button
    $('#search-btn').click(function() {
        const ingredientInput = $('#ingredient-search').val().trim();
        console.log("Search button clicked, input:", ingredientInput);
        
        if (ingredientInput) {
            selectedIngredients = [];
            $('#selected-ingredients').empty();
            
            const ingredients = ingredientInput.split(',').map(item => item.trim()).filter(item => item !== '');
            console.log("Split ingredients:", ingredients);
            
            ingredients.forEach(ingredient => {
                addIngredient(ingredient);
            });
            
            $('#ingredient-search').val('');
            filterRecipes();
        }
    });
    
    // Allow pressing Enter in the search box
    $('#ingredient-search').keypress(function(e) {
        if (e.which === 13) {
            console.log("Enter key pressed in search box");
            $('#search-btn').click();
            return false;
        }
    });
    
    // Make ingredient badges clickable
    $(document).on('click', '.ingredient-badge', function() {
        const ingredient = $(this).data('name');
        console.log("Clicked ingredient:", ingredient);
        if (!selectedIngredients.includes(ingredient.toLowerCase())) {
            addIngredient(ingredient);
            filterRecipes();
        }
    });
    
    // Category checkbox change handler
    $(document).on('change', '.category-filter', function() {
        const categoryId = $(this).val();
        
        if ($(this).is(':checked')) {
            if (!selectedCategories.includes(categoryId)) {
                selectedCategories.push(categoryId);
            }
        } else {
            selectedCategories = selectedCategories.filter(id => id !== categoryId);
        }
        
        console.log("Selected categories:", selectedCategories);
        filterRecipes();
    });
    
    // Clear filters button handler
    $('#clear-filters').click(function() {
        // Clear ingredients
        selectedIngredients = [];
        $('#selected-ingredients').empty();
        
        // Clear categories
        selectedCategories = [];
        $('.category-filter').prop('checked', false);
        
        // Clear search input
        $('#ingredient-search').val('');
        
        // Show all recipes
        filterRecipes();
    });
    
    // Favorite button functionality
    $('.favorite-btn').click(function() {
        const recipeId = $(this).data('recipe-id');
        const button = $(this);
        
        $.ajax({
            url: '{{ route("user.favorites.store") }}',
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
    
    // Function to load popular ingredients from existing recipes
    function loadPopularIngredients() {
        const allIngredients = {};
        console.log("Starting to load popular ingredients");
        
        $('.ingredients-list').each(function() {
            const ingredientsData = $(this).data('ingredients');
            console.log("Found ingredients data:", ingredientsData);
            
            if (ingredientsData) {
                const ingredients = ingredientsData.split(',');
                ingredients.forEach(ing => {
                    if (ing && ing.trim()) {
                        allIngredients[ing.trim()] = (allIngredients[ing.trim()] || 0) + 1;
                    }
                });
            }
        });
        
        console.log("Collected ingredients:", allIngredients);
        
        const sortedIngredients = Object.keys(allIngredients).sort((a, b) => {
            return allIngredients[b] - allIngredients[a];
        });
        
        const popularIngredients = sortedIngredients.slice(0, 10);
        console.log("Popular ingredients:", popularIngredients);
        
        const container = $('#popular-ingredients');
        container.empty();
        
        if (popularIngredients.length === 0) {
            container.html('<div class="text-muted">Aucun ingrédient trouvé</div>');
            return;
        }
        
        popularIngredients.forEach(ing => {
            const badge = $('<span class="badge bg-secondary me-1 mb-1 popular-ingredient" style="cursor: pointer;">' + ing + '</span>');
            badge.click(function() {
                console.log("Clicked popular ingredient:", ing);
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
        console.log("Adding ingredient:", name);
        const normalizedName = name.toLowerCase();
        selectedIngredients.push(normalizedName);
        console.log("Selected ingredients:", selectedIngredients);
        
        const badge = $('<span class="badge bg-primary me-1 mb-1">' + name + ' <i class="fas fa-times"></i></span>');
        badge.find('i').click(function(e) {
            e.stopPropagation();
            badge.remove();
            selectedIngredients = selectedIngredients.filter(ing => ing !== normalizedName);
            console.log("Removed ingredient, remaining:", selectedIngredients);
            filterRecipes();
        });
        
        $('#selected-ingredients').append(badge);
    }
    
    // Function to filter recipes based on selected ingredients and categories
    function filterRecipes() {
        console.log("Filtering recipes with ingredients:", selectedIngredients, "and categories:", selectedCategories);
        
        $('#loading-indicator').removeClass('d-none');
        
        if (selectedIngredients.length === 0 && selectedCategories.length === 0) {
            console.log("No filters applied, showing all recipes");
            $('.recipe-item').show();
            $('#loading-indicator').addClass('d-none');
            $('#no-results-message').remove();
            return;
        }
        
        $('.recipe-item').hide();
        let matchCount = 0;
        
        $('.recipe-item').each(function() {
            const card = $(this);
            let matchesIngredients = true;
            let matchesCategories = true;
            
            // Check ingredients if any are selected
            if (selectedIngredients.length > 0) {
                const ingredientsList = card.find('.ingredients-list').data('ingredients');
                
                if (!ingredientsList) {
                    console.warn("No ingredients data found for recipe", card);
                    matchesIngredients = false;
                } else {
                    const ingredientsArray = ingredientsList.toLowerCase().split(',');
                    
                    matchesIngredients = selectedIngredients.every(ing => 
                        ingredientsArray.some(recipeIng => recipeIng.trim().includes(ing))
                    );
                    
                    if (matchesIngredients) {
                        card.find('.ingredient-badge').each(function() {
                            const badge = $(this);
                            const ingName = badge.data('name').toLowerCase();
                            
                            if (selectedIngredients.some(selected => ingName.includes(selected))) {
                                badge.removeClass('bg-secondary').addClass('bg-success');
                            } else {
                                badge.removeClass('bg-success').addClass('bg-secondary');
                            }
                        });
                    }
                }
            }
            
            // Check categories if any are selected
            if (selectedCategories.length > 0) {
                const categoryId = card.find('.card').data('category-id');
                matchesCategories = selectedCategories.includes(categoryId.toString());
            }
            
            if (matchesIngredients && matchesCategories) {
                matchCount++;
                card.fadeIn(300);
            }
        });
        
        setTimeout(() => {
            $('#loading-indicator').addClass('d-none');
            
            if ($('.recipe-item:visible').length === 0) {
                console.log("No matching recipes found, showing message");
                if ($('#no-results-message').length === 0) {
                    $('#recipes-list').after(
                        '<div id="no-results-message" class="alert alert-info">' +
                        'Aucune recette ne correspond à vos critères.' +
                        '</div>'
                    );
                }
            } else {
                $('#no-results-message').remove();
            }
        }, 300);
    }
    
    // Rating functionality
    $('.rating-star').hover(
        function() {
            const value = $(this).data('value');
            const stars = $(this).parent().find('.rating-star');
            stars.each(function(index) {
                if (index < value) {
                    $(this).addClass('fas text-warning').removeClass('far');
                }
            });
        },
        function() {
            const parent = $(this).parent();
            const recipeId = $(this).data('recipe-id');
            const stars = parent.find('.rating-star');
            
            // Get current user rating from server
            $.get(`{{ url('ratings/user') }}/${recipeId}`, function(response) {
                const userRating = response.rating;
                stars.each(function(index) {
                    if (index < userRating) {
                        $(this).addClass('fas text-warning').removeClass('far');
                    } else {
                        $(this).removeClass('fas text-warning').addClass('far');
                    }
                });
            });
        }
    );

    $('.rating-star').click(function() {
        const value = $(this).data('value');
        const recipeId = $(this).data('recipe-id');
        const stars = $(this).parent().find('.rating-star');
        
        $.ajax({
            url: '{{ route("user.ratings.store") }}',
            method: 'POST',
            data: {
                recipe_id: recipeId,
                rating: value,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Update user rating stars
                stars.each(function(index) {
                    if (index < value) {
                        $(this).addClass('fas text-warning').removeClass('far');
                    } else {
                        $(this).removeClass('fas text-warning').addClass('far');
                    }
                });
                
                // Update average rating display
                const recipeCard = $(`[data-recipe-id="${recipeId}"]`);
                const averageStars = recipeCard.find('.rating-stars .fas');
                const averageText = recipeCard.find('.rating-stars span');
                
                averageStars.each(function(index) {
                    if (index < response.average) {
                        $(this).addClass('text-warning');
                    } else {
                        $(this).removeClass('text-warning');
                    }
                });
                
                averageText.text(`(${response.average.toFixed(1)})`);
            },
            error: function() {
                alert('Une erreur est survenue lors de la notation');
            }
        });
    });
    
    // Helper functions
    function extractLastTerm(term) {
        return splitTerms(term).pop();
    }
    
    function splitTerms(val) {
        return val.split(/,\s*/);
    }
});
</script>
@endsection