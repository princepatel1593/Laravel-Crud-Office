<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    //
    protected $fillable = ['floor_id', 'office_name'];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    // Optional: Access block and site through relationships
    public function block()
    {
        return $this->floor?->block;
    }

    public function site()
    {
        return $this->floor?->block?->site;
    }
}
