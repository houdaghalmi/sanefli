<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recipes Management - Sanefli</title>
    
    <!-- Site Icons -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #FF6B35;
            --secondary-color: #2D3748;
        }

        .sidebar {
            background: var(--secondary-color);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            padding-top: 1rem;
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
            background: #f8f9fa;
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
        }

        .table th {
            background-color: var(--secondary-color);
            color: #fff;
            font-weight: 500;
            border: none;
        }

        .img-thumbnail {
            border-radius: 10px;
            border: 2px solid var(--primary-color);
        }

        .btn-action {
            border-radius: 20px;
            padding: 0.25rem 1rem;
            font-size: 0.875rem;
        }

        .nav-link {
            color: #fff;
            padding: 0.8rem 1rem;
            margin: 0.2rem 0;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: var(--primary-color);
        }

        /* Pagination Custom Style */
        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .pagination .page-link {
            color: var(--primary-color);
        }

        .pagination .page-link:hover {
            color: #fff;
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-wrapper text-center">
            <a href="{{ route('admin.dashboard') }}" class="logo-text text-white fw-bold fs-4">
                SANEFLI
            </a>
        </div>
        
        <div class="nav flex-column mt-4">
            <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-gauge-high me-2"></i> Dashboard
            </a>
            <a class="nav-link {{ Request::is('admin/recipes*') ? 'active' : '' }}" href="{{ route('admin.recipes.index') }}">
                <i class="fas fa-utensils me-2"></i> Recipes
            </a>
            <a class="nav-link {{ Request::is('admin/ingredients*') ? 'active' : '' }}" href="{{ route('admin.ingredients.index') }}">
                <i class="fas fa-carrot me-2"></i> Ingredients
            </a>
            <a class="nav-link {{ Request::is('admin/categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <i class="fas fa-tags me-2"></i> Categories
            </a>
            <a class="nav-link {{ Request::is('admin/preparations*') ? 'active' : '' }}" href="{{ route('admin.preparations.index') }}">
                <i class="fas fa-blender me-2"></i> Preparations
            </a>
        </div>
    </div><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recipes Management - Sanefli</title>
    
    <!-- Site Icons -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #FF6B35;
            --secondary-color: #2D3748;
        }

        .sidebar {
            background: var(--secondary-color);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            padding-top: 1rem;
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
            background: #f8f9fa;
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
        }

        .table th {
            background-color: var(--secondary-color);
            color: #fff;
            font-weight: 500;
            border: none;
        }

        .img-thumbnail {
            border-radius: 10px;
            border: 2px solid var(--primary-color);
        }

        .btn-action {
            border-radius: 20px;
            padding: 0.25rem 1rem;
            font-size: 0.875rem;
        }

        .nav-link {
            color: #fff;
            padding: 0.8rem 1rem;
            margin: 0.2rem 0;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: var(--primary-color);
        }

        /* Pagination Custom Style */
        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .pagination .page-link {
            color: var(--primary-color);
        }

        .pagination .page-link:hover {
            color: #fff;
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
         .form-control {
            border-radius: 10px;
            padding: 0.8rem 1rem;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
        }

        .form-label {
            color: var(--secondary-color);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .preview-image {
            max-width: 200px;
            border-radius: 10px;
            border: 2px solid var(--primary-color);
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-wrapper text-center">
            <a href="{{ route('admin.dashboard') }}" class="logo-text text-white fw-bold fs-4">
                SANEFLI
            </a>
        </div>
        
        <div class="nav flex-column mt-4">
            <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-gauge-high me-2"></i> Dashboard
            </a>
            <a class="nav-link {{ Request::is('admin/recipes*') ? 'active' : '' }}" href="{{ route('admin.recipes.index') }}">
                <i class="fas fa-utensils me-2"></i> Recipes
            </a>
            <a class="nav-link {{ Request::is('admin/ingredients*') ? 'active' : '' }}" href="{{ route('admin.ingredients.index') }}">
                <i class="fas fa-carrot me-2"></i> Ingredients
            </a>
            <a class="nav-link {{ Request::is('admin/categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <i class="fas fa-tags me-2"></i> Categories
            </a>
            <a class="nav-link {{ Request::is('admin/preparations*') ? 'active' : '' }}" href="{{ route('admin.preparations.index') }}">
                <i class="fas fa-blender me-2"></i> Preparations
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Edit Recipe</h2>
                <p class="text-muted mb-0">Modify recipe details</p>
            </div>
            <a href="{{ route('admin.recipes.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i> Back to Recipes
            </a>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('admin.recipes.update', $recipe->id) }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Champs similaires à create.blade.php mais avec les valeurs existantes -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $recipe->name }}" required>
                            </div>
                            
                            <!-- Afficher les ingrédients existants -->
                            @foreach($recipe->preparations as $preparation)
                                <div class="ingredient-item row mb-2">
                                    <!-- Champs pour chaque ingrédient -->
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Current Image</label>
                                <img src="{{ asset('storage/'.$recipe->image) }}" 
                                     alt="{{ $recipe->name }}" 
                                     class="img-fluid preview-image mb-2">
                                
                                <label for="image" class="form-label">Change Image</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="imagePreview" class="mt-2"></div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.recipes.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Update Recipe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- ...same scripts as create.blade.php... -->
</body>
</html>