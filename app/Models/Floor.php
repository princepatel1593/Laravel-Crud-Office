<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    //
    protected $fillable = ['block_id', 'floor_name'];

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function offices()
    {
        return $this->hasMany(Office::class);
    }
}
