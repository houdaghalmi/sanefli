@extends('admin.base')

@section('title', 'Modifier une préparation')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Modifier la préparation</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.preparations.update', $preparation->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="id_recette" class="form-label">Recette</label>
                <select class="form-select @error('id_recette') is-invalid @enderror" 
                        id="id_recette" 
                        name="id_recette" 
                        required>
                    <option value="">Sélectionner une recette</option>
                    @foreach($recettes as $recette)
                        <option value="{{ $recette->id }}" 
                                {{ old('id_recette', $preparation->id_recette) == $recette->id ? 'selected' : '' }}>
                            {{ $recette->name }}
                        </option>
                    @endforeach
                </select>
                @error('id_recette')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nombre_etapes" class="form-label">Nombre d'étapes</label>
                <input type="number" 
                       class="form-control @error('nombre_etapes') is-invalid @enderror"
                       id="nombre_etapes"
                       name="nombre_etapes"
                       value="{{ old('nombre_etapes', $preparation->nombre_etapes) }}"
                       min="1"
                       required
                       onchange="generateStepFields(this.value)">
                @error('nombre_etapes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div id="etapes-container">
                @foreach($preparation->etapes as $index => $etape)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Étape {{ $index + 1 }}</h5>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="etapes[{{ $index }}][description]" 
                                      class="form-control" 
                                      required
                                      rows="3">{{ old("etapes.$index.description", $etape->description) }}</textarea>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
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
</script>
@endpush
@endsection