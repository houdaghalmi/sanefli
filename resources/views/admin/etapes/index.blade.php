
@extends('admin.base')

@section('title', 'Gestion des étapes')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Liste des étapes</h4>
            <a href="{{ route('admin.etapes.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Ajouter une étape
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Recette</th>
                        <th>Numéro d'étape</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($etapes as $etape)
                    <tr>
                        <td>{{ $etape->id }}</td>
                        <td>{{ $etape->preparation->recette->name }}</td>
                        <td>{{ $etape->numero_etape }}</td>
                        <td>{{ Str::limit($etape->description, 50) }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.etapes.show', $etape->id) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.etapes.edit', $etape->id) }}" 
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.etapes.destroy', $etape->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Êtes-vous sûr ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Aucune étape trouvée</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection