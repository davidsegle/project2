<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\JsonResponse;

class PublicGameController extends Controller
{
    // 3 "populārākās"/nejaušas spēles (tikai publicētās)
    public function featured(): JsonResponse
    {
        $items = Game::with(['studio', 'genre'])
            ->where('display', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return response()->json($items);
    }

    // viena spēle pēc ID (tikai publicētās)
    public function show(Game $game): JsonResponse
    {
        if (!$game->display) {
            abort(404);
        }

        $game->load(['studio', 'genre']);

        return response()->json($game);
    }

    // 3 līdzīgas spēles (pēc žanra)
    public function similar(Game $game): JsonResponse
    {
        $items = Game::with(['studio', 'genre'])
            ->where('display', true)
            ->where('genre_id', $game->genre_id)
            ->where('id', '!=', $game->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return response()->json($items);
    }
}
