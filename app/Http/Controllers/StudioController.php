<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StudioController extends Controller
{
    // display all Studios
    public function list(): View
    {
        $items = Studio::orderBy('name', 'asc')->get();

        return view(
            'studio.list',
            [
                'title' => 'Studijas',
                'items' => $items,
            ]
        );
    }
	// display new Studio form
	public function create(): View
	{
		return view(
			'studio.form',
			[
				'title' => 'Pievienot studiju',
				'studio' => new Studio()
			]
		);
	}
	// create new Studio
	public function put(Request $request): RedirectResponse
	{
		$validatedData = $request->validate([
			'name' => 'required|string|max:255',
		]);
		
		$studio = new Studio();
		$studio->name = $validatedData['name'];
		$studio->save();
		return redirect('/studios');
	}
	// display Studio editing form
	public function update(Studio $studio): View
	{
		return view(
			'studio.form',
			[
				'title' => 'Rediģēt studiju',
				'studio' => $studio
			]
		);
	}
	public function patch(Studio $studio, Request $request) : RedirectResponse
	{
		$validatedData = $request->validate([
			'name' => 'required|string|max:255',
		]);
		
		$studio->name = $validatedData['name'];
		$studio->save();
		
		return redirect('/studios');
	}
	
	public function delete(Studio $studio): RedirectResponse
	{
    // Pārbaudām vai studija tiek izmantota games tabulā
    $count = DB::table('games')
        ->where('studio_id', $studio->id)
        ->count();

    if ($count > 0) {
        return redirect('/studios')
            ->with('error', 'Nevar dzēst studiju, jo tai ir piesaistītas spēles!');
    }

    $studio->delete();

    return redirect('/studios')
        ->with('success', 'Studija izdzēsta!');
	}

}
