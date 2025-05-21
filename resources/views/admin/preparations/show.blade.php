@extends('admin.base')

@section('title', 'Détails de la préparation')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Détails de la préparation</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.preparations.edit', $preparation->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('admin.preparations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Informations générales</h5>
                <table class="table">
                    <tr>
                        <th style="width: 200px">Recette</th>
                        <td>{{ $preparation->recette->name }}</td>
                    </tr>
                    <tr>
                        <th>Quantité</th>
                        <td>{{ $preparation->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Temps de préparation</th>
                        <td>{{ $preparation->temps_de_preparation }} minutes</td>
                    </tr>
                    <tr>
                        <th>Nombre d'étapes</th>
                        <td>{{ $preparation->nombre_etapes }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <h5>Étapes de préparation</h5>
            @foreach($preparation->etapes as $etape)
            <div class="card mb-3">
                <div class="card-body">
                    <h6>Étape {{ $etape->numero }}</h6>
                    <p class="mb-0">{{ $etape->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection