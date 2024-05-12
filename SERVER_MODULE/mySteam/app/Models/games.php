<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class games extends Model
{
    use HasFactory;
    public $table = 'games',
    $fillable = [
        'title', 'price', 'description', 'image'
    ];

}
