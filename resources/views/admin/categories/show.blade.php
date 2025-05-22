<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Category - Sanefli</title>
    
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
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .table th {
            color: var(--secondary-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--primary-color);
        }

        .category-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: #fff;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 25px;
        }

        .btn-outline-danger {
            border-radius: 25px;
        }

        .badge {
            background-color: var(--primary-color) !important;
            color: #fff !important;
            padding: 8px 15px;
            border-radius: 15px;
        }

        .page-header h2 {
            color: var(--secondary-color);
            font-weight: 600;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: var(--primary-color);
            color: var(--secondary-color);
            border-radius: 15px;
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

        .logo-wrapper {
            padding: 1rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .logo-text {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 0.1em;
            text-decoration: none;
        }

        .logo-text:hover {
            color: var(--primary-color);
            text-decoration: none;
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
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-wrapper text-center">
            <a href="{{ route('admin.dashboard') }}" class="logo-text">
                SANEFLI
            </a>
        </div>
        
        <div class="nav flex-column">
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
        <!-- Page Header -->
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Category Details</h2>
                <p class="text-muted">View category information and related recipes</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-outline-primary">
                    <i class="fas fa-edit me-2"></i> Edit
                </a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>
        </div>

        <!-- Category Info Card -->
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="category-icon me-3">
                        <i class="fas fa-folder"></i>
                    </div>
                    <h3 class="mb-0">{{ $category->name }}</h3>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted">Created At</label>
                            <p class="mb-0">{{ $category->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted">Total Recipes</label>
                            <p class="mb-0">{{ $category->recettes_count ?? 0 }} recipes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Recipes -->
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Related Recipes</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Recipe Name</th>
                                <th>Created At</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($category->recettes as $recipe)
                                <tr>
                                    <td>{{ $recipe->name }}</td>
                                    <td>{{ $recipe->created_at->format('M d, Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.recipes.show', $recipe->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        <p class="text-muted mb-0">No recipes in this category</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>