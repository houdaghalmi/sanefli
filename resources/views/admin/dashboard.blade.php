<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Sanefli</title>
    
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

        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--secondary-color);
        }

        .stat-label {
            color: #718096;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
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
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">Dashboard Overview</h2>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </div>

        <!-- Statistics -->
        <div class="row g-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number">{{ $totalRecipes ?? 0 }}</div>
                            <div class="stat-label">Total Recipes</div>
                        </div>
                        <i class="fas fa-utensils stat-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number">{{ $totalIngredients ?? 0 }}</div>
                            <div class="stat-label">Ingredients</div>
                        </div>
                        <i class="fas fa-carrot stat-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number">{{ $totalUsers ?? 0 }}</div>
                            <div class="stat-label">Users</div>
                        </div>
                        <i class="fas fa-users stat-icon"></i>
                    </div>
                </div>
            </div>
           
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number">{{ $totalPreparations ?? 0 }}</div>
                            <div class="stat-label">Preparations</div>
                        </div>
                        <i class="fas fa-blender stat-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number">{{ $totalCategories ?? 0 }}</div>
                            <div class="stat-label">Categories</div>
                        </div>
                        <i class="fas fa-tags stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
