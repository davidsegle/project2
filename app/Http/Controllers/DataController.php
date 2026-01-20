<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\JsonResponse;

class DataController extends Controller
{
    // 3 top games (piem.: nejaušas publicētās)
    public function getTopGames(): JsonResponse
    {
        $items = Game::with(['studio', 'genre'])
            ->where('display', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return response()->json($items);
    }

    // get one Game by id (route-model binding)
    public function getGame(Game $game): JsonResponse
    {
        if (!$game->display) {
            abort(404);
        }

        $game->load(['studio', 'genre']);

        return response()->json($game);
    }

    // get related games (piem.: tie paši žanri)
    public function getRelatedGames(Game $game): JsonResponse
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
