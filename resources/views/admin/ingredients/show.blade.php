@extends('admin.base')

@section('title', $ingredient->name)

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4>Détails de l'ingrédient</h4>
            <div>
                <a href="{{ route('admin.ingredients.edit', $ingredient->id) }}" class="btn btn-sm btn-warning">Éditer</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('storage/'.$ingredient->image) }}" class="img-fluid rounded" alt="{{ $ingredient->name }}">
            </div>
            <div class="col-md-8">
                <h3>{{ $ingredient->name }}</h3>
                
                <h5 class="mt-4">Utilisé dans:</h5>
                <ul class="list-group">
                    @foreach($ingredient->preparations as $preparation)
                        <li class="list-group-item">
                            <a href="{{ route('admin.recipes.show', $preparation->recette->id) }}">
                                {{ $preparation->recette->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection