@extends('admin.base')

@section('title', 'Ajouter une préparation')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Nouvelle préparation</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.preparations.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="id_recette" class="form-label">Recette</label>
                <select class="form-select @error('id_recette') is-invalid @enderror" 
                        id="id_recette" 
                        name="id_recette" 
                        required>
                    <option value="">Sélectionner une recette</option>
                    @foreach($recettes as $recette)
                        <option value="{{ $recette->id }}" 
                                {{ old('id_recette') == $recette->id ? 'selected' : '' }}>
                            {{ $recette->name }}
                        </option>
                    @endforeach
                </select>
                @error('id_recette')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantité</label>
                <input type="text" 
                       class="form-control @error('quantity') is-invalid @enderror"
                       id="quantity"
                       name="quantity"
                       value="{{ old('quantity') }}"
                       required>
                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="temps_de_preparation" class="form-label">Temps de préparation (minutes)</label>
                <input type="number" 
                       class="form-control @error('temps_de_preparation') is-invalid @enderror"
                       id="temps_de_preparation"
                       name="temps_de_preparation"
                       value="{{ old('temps_de_preparation') }}"
                       min="1"
                       required>
                @error('temps_de_preparation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nombre_etapes" class="form-label">Nombre d'étapes</label>
                <input type="number" 
                       class="form-control @error('nombre_etapes') is-invalid @enderror"
                       id="nombre_etapes"
                       name="nombre_etapes"
                       value="{{ old('nombre_etapes') }}"
                       min="1"
                       required
                       onchange="generateStepFields(this.value)">
                @error('nombre_etapes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div id="etapes-container">
                <!-- Les champs d'étapes seront générés ici -->
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.preparations.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function generateStepFields(number) {
    const container = document.getElementById('etapes-container');
    container.innerHTML = '';
    
    for(let i = 0; i < number; i++) {
        container.innerHTML += `
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Étape ${i + 1}</h5>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="etapes[${i}][description]" 
                                  class="form-control" 
                                  required
                                  rows="3"></textarea>
                    </div>
                </div>
            </div>
        `;
    }
}

// Generate fields if nombre_etapes has old value
document.addEventListener('DOMContentLoaded', function() {
    const nombreEtapes = document.getElementById('nombre_etapes');
    if (nombreEtapes.value) {
        generateStepFields(nombreEtapes.value);
    }
});
</script>
@endpush
@endsection