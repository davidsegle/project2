@extends('layout')

@section('content')
    <h1>{{ $title }}</h1>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (count($items) > 0)
        <table class="table table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nosaukums</th>
                    <th style="width: 220px;">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $genre)
                    <tr>
                        <td>{{ $genre->id }}</td>
                        <td>{{ $genre->name }}</td>
                        <td class="text-end">
                            <a href="/genres/update/{{ $genre->id }}" class="btn btn-outline-primary btn-sm">Labot</a>

                            <form method="post" action="/genres/delete/{{ $genre->id }}" class="d-inline deletion-form">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">Dzēst</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Nav atrasts neviens ieraksts</p>
    @endif

    <a href="/genres/create" class="btn btn-primary">Izveidot jaunu</a>
@endsection
