<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JsonSerializable;

class Game extends Model
{
    protected $fillable = [
        'studio_id',
        'genre_id',
        'name',
        'description',
        'price',
        'year',
        'image',
        'display',
    ];

    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
	public function jsonSerialize(): mixed
    {
        return [
            'id' => intval($this->id),
            'name' => $this->name,
            'description' => $this->description,
            'studio' => $this->studio ? $this->studio->name : '',
            'genre' => $this->genre ? $this->genre->name : '',
            'price' => $this->price !== null ? number_format($this->price, 2) : '',
            'year' => $this->year !== null ? intval($this->year) : null,
            'image' => $this->image ? asset('images/' . $this->image) : '',
        ];
    }
}
