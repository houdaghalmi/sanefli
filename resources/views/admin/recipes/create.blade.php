@extends('admin.base')

@section('title', 'Ajouter une recette')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Nouvelle recette</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.recipes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">Nom de la recette</label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="id_category" class="form-label">Catégorie</label>
                <select class="form-select @error('id_category') is-invalid @enderror" 
                        id="id_category" 
                        name="id_category" 
                        required>
                    <option value="">Sélectionner une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                                {{ old('id_category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('id_category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="ingredients" class="form-label">Ingrédients</label>
                <select class="form-select @error('ingredients') is-invalid @enderror" 
                        id="ingredients" 
                        name="ingredients[]" 
                        multiple
                        required>
                    @foreach($ingredients as $ingredient)
                        <option value="{{ $ingredient->id }}" 
                                {{ in_array($ingredient->id, old('ingredients', [])) ? 'selected' : '' }}>
                            {{ $ingredient->name }}
                        </option>
                    @endforeach
                </select>
                @error('ingredients')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" 
                       class="form-control @error('image') is-invalid @enderror" 
                       id="image" 
                       name="image"
                       accept="image/*"
                       onchange="previewImage(this)">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="imagePreview" class="mt-2 d-none">
                    <img src="#" alt="Preview" class="img-thumbnail" style="max-width: 200px">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.recipes.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.querySelector('#imagePreview');
    const image = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            image.src = e.target.result;
            preview.classList.remove('d-none');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        image.src = '#';
        preview.classList.add('d-none');
    }
}

// Initialize select2 for ingredients
document.addEventListener('DOMContentLoaded', function() {
    $('#ingredients').select2({
        placeholder: "Sélectionnez des ingrédients",
        allowClear: true
    });
});
</script>
@endpush
@endsection