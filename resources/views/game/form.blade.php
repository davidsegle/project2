@extends('layout')

@section('content')
<h1>{{ $title }}</h1>

@if ($errors->any())
    <div class="alert alert-danger">Lūdzu, novērsiet radušās kļūdas!</div>
@endif

<form method="post" action="{{ $game->exists ? '/games/patch/' . $game->id : '/games/put' }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="game-name" class="form-label">Nosaukums</label>
        <input
            type="text"
            id="game-name"
            name="name"
            value="{{ old('name', $game->name) }}"
            class="form-control @error('name') is-invalid @enderror"
        >
        @error('name')
            <p class="invalid-feedback">{{ $errors->first('name') }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="game-studio" class="form-label">Studija</label>
        <select
            id="game-studio"
            name="studio_id"
            class="form-select @error('studio_id') is-invalid @enderror"
        >
            <option value="">Norādiet studiju!</option>

            @foreach($studios as $studio)
                <option
                    value="{{ $studio->id }}"
                    @if ($studio->id == old('studio_id', $game->studio->id ?? false)) selected @endif
                >
                    {{ $studio->name }}
                </option>
            @endforeach
        </select>

        @error('studio_id')
            <p class="invalid-feedback">{{ $errors->first('studio_id') }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="game-genre" class="form-label">Žanrs</label>
        <select
            id="game-genre"
            name="genre_id"
            class="form-select @error('genre_id') is-invalid @enderror"
        >
            <option value="">Norādiet žanru!</option>

            @foreach($genres as $genre)
                <option
                    value="{{ $genre->id }}"
                    @if ($genre->id == old('genre_id', $game->genre->id ?? false)) selected @endif
                >
                    {{ $genre->name }}
                </option>
            @endforeach
        </select>

        @error('genre_id')
            <p class="invalid-feedback">{{ $errors->first('genre_id') }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="game-description" class="form-label">Apraksts</label>
        <textarea
            id="game-description"
            name="description"
            class="form-control @error('description') is-invalid @enderror"
        >{{ old('description', $game->description) }}</textarea>

        @error('description')
            <p class="invalid-feedback">{{ $errors->first('description') }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="game-year" class="form-label">Izdošanas gads</label>
        <input
            type="number"
            max="{{ date('Y') + 1 }}"
            step="1"
            id="game-year"
            name="year"
            value="{{ old('year', $game->year) }}"
            class="form-control @error('year') is-invalid @enderror"
        >
        @error('year')
            <p class="invalid-feedback">{{ $errors->first('year') }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="game-price" class="form-label">Cena</label>
        <input
            type="number"
            min="0.00"
            step="0.01"
            lang="en"
            id="game-price"
            name="price"
            value="{{ old('price', $game->price) }}"
            class="form-control @error('price') is-invalid @enderror"
        >
        @error('price')
            <p class="invalid-feedback">{{ $errors->first('price') }}</p>
        @enderror
    </div>

    <div class="mb-3">
		<label for="game-image" class="form-label">Attēls</label>
		
		@if ($game->image)
			<img
				src="{{ asset('images/' . $game->image) }}"
				class="img-fluid img-thumbnail d-block mb-2"
				alt="{{ $game->name }}"
			>
		@endif
		
		<input
			type="file" accept="image/png, image/jpeg, image/webp"
			id="game-image"
			name="image"
			class="form-control @error('image') is-invalid @enderror"
		>
		
		@error('image')
			<p class="invalid-feedback">{{ $errors->first('image') }}</p>
		@enderror
	</div>


    <div class="mb-3">
        <div class="form-check">
            <input
                type="checkbox"
                id="game-display"
                name="display"
                value="1"
                class="form-check-input @error('display') is-invalid @enderror"
                @if (old('display', $game->display)) checked @endif
            >
            <label class="form-check-label" for="game-display">
                Publicēt ierakstu
            </label>

            @error('display')
                <p class="invalid-feedback">{{ $errors->first('display') }}</p>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        {{ $game->exists ? 'Atjaunot ierakstu' : 'Pievienot ierakstu' }}
    </button>
</form>
@endsection
