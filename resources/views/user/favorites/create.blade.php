@extends('user.base')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Ajouter une recette aux favoris</h4>
                </div>
                <div class="card-body">
                    <form id="addFavoriteForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="recette_id" class="form-label">Sélectionner une recette</label>
                            <select class="form-select" id="recette_id" name="recette_id" required>
                                <option value="">-- Choisir une recette --</option>
                                @foreach($allRecipes as $recipe)
                                    <option value="{{ $recipe->id }}">{{ $recipe->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter aux favoris</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
$(document).ready(function() {
    $('#addFavoriteForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("user.favorites.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response.message);
                if(response.status === 'added') {
                    window.location.href = '{{ route("user.favorites.index") }}';
                }
            },
            error: function(xhr) {
                alert('Une erreur est survenue');
            }
        });
    });
});
</script>
@endsection
@endsection