<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $table = 'studios';

    // PK "idstudios"
    protected $primaryKey = 'idstudios';

    
    public $timestamps = true;

    
    protected $fillable = ['name'];
}
