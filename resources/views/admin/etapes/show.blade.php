
@extends('admin.base')

@section('title', 'Détails de l\'étape')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Détails de l'étape</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.etapes.edit', $etape->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('admin.etapes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th style="width: 200px">Recette</th>
                        <td>{{ $etape->preparation->recette->name }}</td>
                    </tr>
                    <tr>
                        <th>Numéro d'étape</th>
                        <td>{{ $etape->numero_etape }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <h5>Description</h5>
            <div class="card">
                <div class="card-body">
                    {{ $etape->description }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection