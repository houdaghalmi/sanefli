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
    /* Make the autocomplete open upward when near the bottom of the page */
    .ui-autocomplete-up {
        max-height: 300px;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 9999;
        border: 1px solid #ddd;
        border-radius: 4px 4px 0 0;
        box-shadow: 0 -4px 8px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Nos Recettes</h3>

    <!-- Ingredients Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <label for="ingredient-search" class="form-label">Filtrer par ingrédients</label>
                    <div class="input-group mb-2 search-container">
                        <input type="text" id="ingredient-search" class="form-control" 
                               placeholder="Ex: tomate, oignon, poulet">
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
                        <!-- Will be populated by JavaScript -->
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
                        <div class="card h-100 shadow-sm">
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
                                    <a href="{{ route('user.recipes.show', $recipe->id) }}" class="btn btn-primary">Voir</a>
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
            
            <div class="d-flex justify-content-center mt-4">
                {{ $recipes->links() }}
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
    
    // Array to store selected ingredients for filtering
    let selectedIngredients = [];
    
    // Setup autocomplete
    $("#ingredient-search").autocomplete({
        source: function(request, response) {
            // Extract the last term from a comma-separated list
            const lastTerm = extractLastTerm(request.term);
            
            // Always search, even with very short input
            $.ajax({
                url: "{{ route('user.ingredients.autocomplete') }}",
                data: {
                    query: lastTerm
                },
                success: function(data) {
                    // Process the data to create groupings by letter
                    let result = [];
                    let currentCategory = '';
                    
                    for (let i = 0; i < data.length; i++) {
                        if (data[i].category !== undefined) {
                            // This is a category header
                            if (currentCategory !== data[i].category) {
                                currentCategory = data[i].category;
                                // Add a special category item
                                result.push({
                                    label: currentCategory,
                                    value: '',
                                    isCategory: true
                                });
                            }
                        } else {
                            // This is a regular item
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
        minLength: 0, // Show all options
        delay: 0, // No delay for immediate response
        focus: function() {
            // Prevent value inserted on focus
            return false;
        },
        select: function(event, ui) {
            // Skip if it's a category header
            if (ui.item.isCategory) {
                return false;
            }
            
            const terms = splitTerms(this.value);
            // Remove the current input
            terms.pop();
            // Add the selected item
            terms.push(ui.item.value);
            // Add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join(", ");
            return false;
        }
    }).data("ui-autocomplete")._renderItem = function(ul, item) {
        if (item.isCategory) {
            // Render a category header
            return $("<li>")
                .addClass("autocomplete-category")
                .append(item.label)
                .appendTo(ul);
        } else {
            // Render a regular item
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
        
        // Add typing class to parent for styling
        $('.search-container').addClass('typing');
        
        // Remove typing class after delay
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
            // Clear previous ingredients
            selectedIngredients = [];
            $('#selected-ingredients').empty();
            
            // Split by comma and add each ingredient
            const ingredients = ingredientInput.split(',').map(item => item.trim()).filter(item => item !== '');
            console.log("Split ingredients:", ingredients);
            
            // Add each ingredient to the filter
            ingredients.forEach(ingredient => {
                addIngredient(ingredient);
            });
            
            // Clear the input field
            $('#ingredient-search').val('');
            
            // Apply filtering
            filterRecipes();
        }
    });
    
    // Change input placeholder to indicate comma usage
    $('#ingredient-search').attr('placeholder', 'Entrez des ingrédients (séparés par des virgules)...');
    
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
        
        // Collect all ingredients from the page
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
        
        // Sort by frequency
        const sortedIngredients = Object.keys(allIngredients).sort((a, b) => {
            return allIngredients[b] - allIngredients[a];
        });
        
        // Take the top 10
        const popularIngredients = sortedIngredients.slice(0, 10);
        console.log("Popular ingredients:", popularIngredients);
        
        // Populate the quick filters
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
            e.stopPropagation(); // Prevent event bubbling
            badge.remove();
            selectedIngredients = selectedIngredients.filter(ing => ing !== normalizedName);
            console.log("Removed ingredient, remaining:", selectedIngredients);
            filterRecipes();
        });
        
        $('#selected-ingredients').append(badge);
    }
    
    // Function to filter recipes based on selected ingredients
    function filterRecipes() {
        console.log("Filtering recipes with ingredients:", selectedIngredients);
        
        // Show loading indicator
        $('#loading-indicator').removeClass('d-none');
        
        if (selectedIngredients.length === 0) {
            // If no filters, show all recipes
            console.log("No filters applied, showing all recipes");
            $('.recipe-item').show();
            $('#loading-indicator').addClass('d-none');
            $('#no-results-message').remove();
            return;
        }
        
        // Hide all recipes initially
        $('.recipe-item').hide();
        
        let matchCount = 0;
        
        // Check each recipe
        $('.recipe-item').each(function() {
            const card = $(this);
            const ingredientsList = card.find('.ingredients-list').data('ingredients');
            
            if (!ingredientsList) {
                console.warn("No ingredients data found for recipe", card);
                return;
            }
            
            const ingredientsArray = ingredientsList.toLowerCase().split(',');
            console.log("Recipe ingredients:", ingredientsArray);
            
            // Check if all selected ingredients are in this recipe
            const hasAllIngredients = selectedIngredients.every(ing => 
                ingredientsArray.some(recipeIng => recipeIng.trim().includes(ing))
            );
            
            console.log("Recipe has all ingredients:", hasAllIngredients);
            
            if (hasAllIngredients) {
                matchCount++;
                
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
        
        console.log("Total matches found:", matchCount);
        
        // Hide loading indicator after a short delay
        setTimeout(() => {
            $('#loading-indicator').addClass('d-none');
            
            // If no results, show message
            if ($('.recipe-item:visible').length === 0) {
                console.log("No matching recipes found, showing message");
                if ($('#no-results-message').length === 0) {
                    $('#recipes-list').after(
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
    
    // Extract the last term from a comma-separated string
    function extractLastTerm(term) {
        return splitTerms(term).pop();
    }
    
    // Split terms by comma
    function splitTerms(val) {
        return val.split(/,\s*/);
    }
});
</script>
@endsection