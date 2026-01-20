<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class GenreController extends Controller implements HasMiddleware
{
    // call auth middleware
    public static function middleware(): array
    {
        return ['auth'];
    }

    // display all Genres
    public function list(): View
    {
        $items = Genre::orderBy('name', 'asc')->get();

        return view('genre.list', [
            'title' => 'Žanri',
            'items' => $items,
        ]);
    }

    // display new Genre form
    public function create(): View
    {
        return view('genre.form', [
            'title' => 'Pievienot žanru',
            'genre' => new Genre(),
        ]);
    }

    // create new Genre
    public function put(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:2|max:255',
        ]);

        $genre = new Genre();
        $genre->fill($validatedData);
        $genre->save();

        return redirect('/genres');
    }

    // display Genre editing form
    public function update(Genre $genre): View
    {
        return view('genre.form', [
            'title' => 'Rediģēt žanru',
            'genre' => $genre,
        ]);
    }

    // update Genre data
    public function patch(Genre $genre, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:2|max:255',
        ]);

        $genre->fill($validatedData);
        $genre->save();

        return redirect('/genres/update/' . $genre->id);
    }

    // delete Genre
    public function delete(Genre $genre): RedirectResponse
    {
        // Neļaujam dzēst žanru, ja tam ir piesaistītas spēles
        if ($genre->games()->count() > 0) {
            return redirect('/genres')->with('error', 'Nevar dzēst žanru, jo tam ir piesaistītas spēles!');
        }

        $genre->delete();

        return redirect('/genres')->with('success', 'Žanrs izdzēsts!');
    }
}
