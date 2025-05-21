@extends('admin.base')

@section('title', 'Gestion des préparations')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Liste des préparations</h4>
            <a href="{{ route('admin.preparations.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Ajouter une préparation
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
                        <th>Nombre d'étapes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($preparations as $preparation)
                    <tr>
                        <td>{{ $preparation->id }}</td>
                        <td>{{ $preparation->recette->name }}</td>
                        <td>{{ $preparation->nombre_etapes }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.preparations.show', $preparation->id) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye">view</i>
                                </a>
                                <a href="{{ route('admin.preparations.edit', $preparation->id) }}" 
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit">edit</i>
                                </a>
                                <form action="{{ route('admin.preparations.destroy', $preparation->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette préparation ?')">
                                        <i class="fas fa-trash">delete</i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucune préparation trouvée</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection