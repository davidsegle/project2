<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Genre extends Model
{
    protected $fillable = ['name'];

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }
	public function genre(): BelongsTo
	{
		return $this->belongsTo(Genre::class);
	}
}
