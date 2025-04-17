<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    //
    protected $fillable = ['site_name'];

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
}
