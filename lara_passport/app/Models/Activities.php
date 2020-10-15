<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    public $table = 'activities';
    use HasFactory;
    protected $guarded = [];

    public function participants()
    {
    	return $this->belongsToMany('App\Models\User');
    }
}
