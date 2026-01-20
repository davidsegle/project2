<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\Genre;
use App\Models\Game;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\GameRequest;

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
	public function put(GameRequest$request)
	{
		$game = new Game();
		$this->saveGameData($game, $request);

		return redirect('/games');
	}

	public function patch(Game $game, GameRequest $request)
	{
		$this->saveGameData($game, $request);

		return redirect('/games/update/' . $game->id);
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
	// validate and save Game data
	private function saveGameData(Game $game, GameRequest $request)
	{
		$validatedData = $request->validated();
		

		$game->fill($validatedData);
		$game->display = (bool) ($validatedData['display'] ?? false);

		if ($request->hasFile('image')) {
			// ja bija vecs attēls, to var nodzēst
			if ($game->image) {
				@unlink(getcwd() . '/images/' . $game->image);
			}

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
	}


}
