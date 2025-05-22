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
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Recipe Management</h2>
                <p class="text-muted mb-0">Manage all your recipes</p>
            </div>
            <a href="{{ route('admin.recipes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i> Add New Recipe
            </a>
        </div>

        <!-- Recipes Card -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recipes as $recipe)
                                <tr>
                                    <td class="px-4 py-3">
                                        <img src="{{ asset('storage/'.$recipe->image) }}" 
                                             alt="{{ $recipe->name }}" 
                                             width="50" 
                                             class="img-thumbnail">
                                    </td>
                                    <td class="px-4 py-3">{{ $recipe->name }}</td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-primary">{{ $recipe->category->name }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('admin.recipes.show', $recipe->id) }}" 
                                               class="btn btn-sm btn-outline-info btn-action">
                                                <i class="fas fa-eye me-1"></i> View
                                            </a>
                                            <a href="{{ route('admin.recipes.edit', $recipe->id) }}" 
                                               class="btn btn-sm btn-outline-warning btn-action">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.recipes.destroy', $recipe->id) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger btn-action"
                                                        onclick="return confirm('Are you sure you want to delete this recipe?')">
                                                    <i class="fas fa-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <i class="fas fa-utensils fa-2x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">No recipes found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center py-4">
                    {{ $recipes->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
