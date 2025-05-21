@extends('admin.base')

@section('title', 'Gestion des ingrédients')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Liste des ingrédients</h4>
            <a href="{{ route('admin.ingredients.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Ajouter un ingrédient
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ingredients as $ingredient)
                    <tr>
                        <td>
                            @if($ingredient->image)
                                <img src="{{ asset('storage/'.$ingredient->image) }}" alt="{{ $ingredient->name }}" width="50" class="img-thumbnail">
                            @else
                                <span class="text-muted">Aucune image</span>
                            @endif
                        </td>
                        <td>{{ $ingredient->name }}</td>

                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.ingredients.edit', $ingredient->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit">edit</i>
                                </a>
                                <form action="{{ route('admin.ingredients.destroy', $ingredient->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">
                                        <i class="fas fa-trash">delete</i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Aucun ingrédient trouvé</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection