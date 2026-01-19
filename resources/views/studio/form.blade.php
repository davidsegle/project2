@extends('layout')
@section('content')
	<h1>{{ $title }}</h1>
	@if ($errors->any())
		<div class="alert alert-danger">Lūdzu, novērsiet radušās kļūdas!</div>
	@endif
	
	<form method="post" action="{{ $studio->exists ? '/studios/patch/' . $studio->id : '/studios/put' }}">
		@csrf
			<div class="mb-3">
			<label for="studio-name" class="form-label">Studijas vārds</label>
				<input
				type="text"
				class="form-control @error('name') is-invalid @enderror"
				id="studio-name"
				name="name"
				value="{{ old('name', $studio->name) }}"
				>
				
			@error('name')
				<p class="invalid-feedback">{{ $errors->first('name') }}</p>
			@enderror
		</div>
		
		<button type="submit" class="btn btn-primary">
			{{ $studio->exists ? 'Atjaunot studiju' : 'Pievienot studiju' }}
		</button>

		
	</form>
@endsection