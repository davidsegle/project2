<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\Genre;
use App\Models\Game;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class GameController extends Controller implements HasMiddleware
{
    public static function middleware(): array
	{
			return [
				'auth',
			];
	}
	public function list(): view
	{
		$items = Game::orderBy('name', 'asc')->get();
		
		return view(
			'game.list',
			[
				'title' => 'Spēles',
				'items' => $items
			]
		);
	}
	// display new Game form
	public function create(): view
	{
		$studios = Studio::orderBy('name', 'asc')->get();
		$genres = Genre::orderBy('name', 'asc')->get();
		
		return view(
			'game.form',
			[
				'title' => "Pievienot spēli",
				'game' => new Game(),
				'studios' => $studios,
				'genres' => $genres,
			]
		);
	}
	// create new Game entry
	public function put(Request $request): RedirectResponse
	{
		$validatedData = $request->validate([
			'name' => 'required|min:3|max:256',
			'studio_id' => 'required',
			'genre_id' => 'required',
			'description' => 'nullable',
			'price' => 'nullable|numeric',
			'year' => 'numeric',
			'image' => 'nullable|image',
			'display' => 'nullable',
		]);
		$game = new game();
		$game->name = $validatedData['name'];
		$game->studio_id = $validatedData['studio_id'];
		$game->genre_id = $validatedData['genre_id'];
		$game->description = $validatedData['description'];
		$game->price = $validatedData['price'];
		$game->year = $validatedData['year'];
		$game->display = (bool) ($validatedData['display'] ?? false);
		
		if ($request->hasFile('image')) {
		// šeit varat pievienot kodu, kas nodzēš veco bildi, ja pievieno jaunu
			$uploadedFile = $request->file('image');
			$extension = $uploadedFile->clientExtension();
			$name = uniqid();
			$game->image = $uploadedFile->storePubliclyAs(
				'/',
				$name . '.' . $extension,
				'uploads'
			);
		}

		$game->save();
		
		return redirect('/games');
	}
	// display Game edit form
	public function update(Game $game): View
	{
		$studios = Studio::orderBy('name', 'asc')->get();
		$genres  = Genre::orderBy('name', 'asc')->get();

		return view('game.form', [
			'title' => 'Rediģēt spēli',
			'game' => $game,
			'studios' => $studios,
			'genres' => $genres,
		]);
	}

	// update Game data
	public function patch(Game $game, Request $request): RedirectResponse
	{
		$validatedData = $request->validate([
			'name' => 'required|min:3|max:256',
			'studio_id' => 'required|integer',
			'genre_id' => 'required|integer',
			'description' => 'nullable|string',
			'price' => 'nullable|numeric',
			'year' => 'nullable|integer',
			'display' => 'nullable',
		]);

		$game->name = $validatedData['name'];
		$game->studio_id = $validatedData['studio_id'];
		$game->genre_id = $validatedData['genre_id'];
		$game->description = $validatedData['description'] ?? null;
		$game->price = $validatedData['price'] ?? null;
		$game->year = $validatedData['year'] ?? null;
		$game->display = (bool) ($validatedData['display'] ?? false);
		
		if ($request->hasFile('image')) {
		// šeit varat pievienot kodu, kas nodzēš veco bildi, ja pievieno jaunu
			$uploadedFile = $request->file('image');
			$extension = $uploadedFile->clientExtension();
			$name = uniqid();
			$game->image = $uploadedFile->storePubliclyAs(
				'/',
				$name . '.' . $extension,
				'uploads'
			);
		}
		
		$game->save();

		return redirect('/games/update/' . $game->id);
	}
	// delete Game
	public function delete(Game $game): RedirectResponse
	{
		if($game->image){
			unlink(getcwd() . '/images/' . $book->image);
		}
		
		// dzēšam arī bildes
		$game->delete();
		return redirect('/games');
	}

}
