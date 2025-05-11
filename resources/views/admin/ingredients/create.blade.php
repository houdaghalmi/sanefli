@extends('admin.base')

@section('title', 'Ajouter un ingrédient')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Nouvel ingrédient</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.ingredients.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
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
            
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('admin.ingredients.index') }}" class="btn btn-secondary">Annuler</a>
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
</script>
@endpush
@endsection