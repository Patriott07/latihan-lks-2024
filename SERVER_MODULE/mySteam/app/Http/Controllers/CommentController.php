<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function postComment(Request $request){

        $user = Auth::user();
        $request['user_id'] = $user->id;
        comment::create($request->all());

        return response()->json(['message' => 'Succes add comment']);
    }

    public function getComment(Request $request, $id_game){
        $comment = comment::with(['user'])->where('game_id', $id_game)->get();

        // dd($comment);
        // return response()->json(['comments' ])
    }
}
