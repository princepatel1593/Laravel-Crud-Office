<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    //
    protected $fillable = ['site_id', 'block_name'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }
}
