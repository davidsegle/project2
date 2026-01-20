@extends('layout')

@section('content')

<h1>{{ $title }}</h1>

@if (count($items) > 0)
	
	<table class="table table-sm table-hover table-striped">
		<thead class="thead-light">
			<tr>
				<th>ID</th>
				<th>Nosaukums</th>
				<th>Studija</th>
				<th>Žanrs</th>
				<th>Gads</th>
				<th>Cena</th>
				<th>Attēlot</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		
		@foreach($items as $game)
			<tr>
				<td>{{$game ->id}}</td>
				<td>{{$game ->name}}</td>
				<td>{{$game ->studio->name}}</td>
				<td>{{$game->genre->name}}</td>
				<td>{{$game ->year}}</td>
				<td>&euro;{{number_format($game->price, 2, '.')}}</td>
				<td>{!! $game->display ? '&#x2714;' : '&#x274C;' !!}</td>
				<td>
					<a
						href="/games/update/{{$game->id}}"
						class="btn btn-outline-primary btn-sm"
					>Labot</a> /
					
					<form
						method="post"
						action="/games/delete/{{$game->id}}"
						class="d-inline deletion-form"
					>
						@csrf
						<button
							type="submit"
							class="btn btn-outline-danger btn-sm"
						>Dzēst</button>
					</form>
				</td>
			</tr>
		@endforeach
		
		</tbody>
	</table>
	
@else
	<p>Nav atrast neviens ieraksts</p>
@endif

<a href="/games/create" class="btn btn-primary">Pievienot jaunu</a>

@endsection