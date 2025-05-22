<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories Management - Sanefli</title>
    
    <!-- Site Icons -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Site CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
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

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Categories Management</h2>
                <p class="text-muted">Manage and organize your recipe categories</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i> New Category
            </a>
        </div>
        

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Categories Card -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">Category Name</th>
                                <th class="px-4 py-3">Recipes Count</th>
                                <th class="px-4 py-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="category-icon me-3">
                                                <i class="fas fa-folder text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $category->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-light text-dark">
                                            {{ $category->recettes_count ?? 0 }} recipes
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit me-1"></i>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                                    <i class="fas fa-trash-alt me-1"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-3"></i>
                                        <p class="mb-0">No categories found</p>
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
