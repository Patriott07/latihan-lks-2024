<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gallery_games extends Model
{
    use HasFactory;
    public $table = 'gallery_games',
    $fillable = ['storage_path', 'game_id'];

    
}
