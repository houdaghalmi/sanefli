
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
                                {{ (old('id_recette', $preparation->id_recette) == $recette->id) ? 'selected' : '' }}>
                            {{ $recette->name }}
                        </option>
                    @endforeach
                </select>
                @error('id_recette')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="id_ingredient" class="form-label">Ingrédient</label>
                <select class="form-select @error('id_ingredient') is-invalid @enderror" 
                        id="id_ingredient" 
                        name="id_ingredient" 
                        required>
                    <option value="">Sélectionner un ingrédient</option>
                    @foreach($ingredients as $ingredient)
                        <option value="{{ $ingredient->id }}" 
                                {{ (old('id_ingredient', $preparation->id_ingredient) == $ingredient->id) ? 'selected' : '' }}>
                            {{ $ingredient->name }}
                        </option>
                    @endforeach
                </select>
                @error('id_ingredient')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantité</label>
                <input type="text" 
                       class="form-control @error('quantity') is-invalid @enderror" 
                       id="quantity" 
                       name="quantity" 
                       value="{{ old('quantity', $preparation->quantity) }}"
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
                       value="{{ old('temps_de_preparation', $preparation->temps_de_preparation) }}"
                       min="1"
                       required>
                @error('temps_de_preparation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" 
                          name="description" 
                          rows="3"
                          required>{{ old('description', $preparation->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.preparations.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection