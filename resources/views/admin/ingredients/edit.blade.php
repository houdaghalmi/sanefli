@extends('admin.base')

@section('title', 'Modifier ingrédient')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Éditer : {{ $ingredient->name }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.ingredients.update', $ingredient->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="{{ $ingredient->name }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Image actuelle</label>
                <img src="{{ asset('storage/'.$ingredient->image) }}" width="100" class="d-block mb-2">
                <input type="file" class="form-control" id="image" name="image">
            </div>
            
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
</div>
@endsection