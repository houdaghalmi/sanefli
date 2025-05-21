
@extends('admin.base')

@section('title', 'Ajouter une étape')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Nouvelle étape</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.etapes.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="preparation_id" class="form-label">Préparation</label>
                <select class="form-select @error('preparation_id') is-invalid @enderror" 
                        id="preparation_id" 
                        name="preparation_id" 
                        required>
                    <option value="">Sélectionner une préparation</option>
                    @foreach($preparations as $preparation)
                        <option value="{{ $preparation->id }}" 
                                {{ old('preparation_id') == $preparation->id ? 'selected' : '' }}>
                            {{ $preparation->recette->name }}
                        </option>
                    @endforeach
                </select>
                @error('preparation_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="numero_etape" class="form-label">Numéro de l'étape</label>
                <input type="number" 
                       class="form-control @error('numero_etape') is-invalid @enderror"
                       id="numero_etape"
                       name="numero_etape"
                       value="{{ old('numero_etape') }}"
                       min="1"
                       required>
                @error('numero_etape')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description"
                          name="description"
                          rows="3"
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.etapes.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection