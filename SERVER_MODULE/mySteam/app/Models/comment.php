<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class comment extends Model
{
    use HasFactory;
    public $table = 'comments',
    $fillable = [
        'user_id', 'game_id', 'content'
    ];

    public function user(){
        return $this->belongsto(User::class, 'id', 'user_id');
    }
}
