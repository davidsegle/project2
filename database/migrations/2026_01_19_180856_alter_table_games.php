<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->foreign('studio_id')->references('id')->on('studios');
            $table->foreign('genre_id')->references('id')->on('genres');
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign('games_studio_id_foreign');
            $table->dropForeign('games_genre_id_foreign');
        });
    }
};
