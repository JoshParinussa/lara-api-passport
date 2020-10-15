<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    public $table = 'Profiles';
    use HasFactory;
    protected $fillable = [
        'profile_name',
    ];
}
