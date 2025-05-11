@extends('admin.base')

@section('title', $category->name)

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Détails de la catégorie</h4>
            <div>
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <h3>{{ $category->name }}</h3>
                <p class="text-muted">Slug: {{ $category->slug }}</p>
                
                @if($category->description)
                    <div class="mt-4">
                        <h5>Description</h5>
                        <p>{{ $category->description }}</p>
                    </div>
                @endif
                
                <div class="mt-4">
                    <h5>Recettes associées ({{ $category->recipes_count }})</h5>
                    @if($category->recipes_count > 0)
                        <ul class="list-group">
                            @foreach($category->recipes as $recipe)
                                <li class="list-group-item">
                                    <a href="{{ route('admin.recipes.show', $recipe->id) }}">
                                        {{ $recipe->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Aucune recette dans cette catégorie</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection