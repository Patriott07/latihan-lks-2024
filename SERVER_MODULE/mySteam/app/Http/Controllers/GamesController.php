<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\games;
use App\Models\gallery_games;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class GamesController extends Controller
{
    public function create(Request $request){
        //title, des, image, price

        $validate = validator($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'image_file' => 'required|file|mimes:jpg,png,jpeg',
            'price' => 'required'
        ]);

        if($request->hasFile('image_file')){
            $file = $request->file('image_file');
            $storagePath = $file->store('public/image');
            
            $request['image'] = Storage::url($storagePath);
        }

        $game = games::create($request->all());

        if($request->has('gallery')){
            foreach($request->gallery as $file){
                $path = $file->store('public/image');
                gallery_games::create([
                    'game_id' => $game->id,
                    'storage_path' => Storage::url($path) 
                ]);
            }
        }

        return response()->json(['message' => 'Games was uploaded']);
    }

    public function getAllGames(Request $request){
        $page = $request->get('p');
        $limit = 15;
        $offset = $limit * $page;

        if($request->has('categ')){    
            $getGames = DB::select("SELECT games.* FROM `games`, category, pivot_category WHERE pivot_category.game_id = games.id AND pivot_category.category_id = category.id AND pivot_category.category_id = $request->categ LIMIT $limit OFFSET $offset");
        }else{ 
            $getGames = DB::select("SELECT * FROM `games` LIMIT $limit OFFSET $offset");
        }

        // dd($getGames);
        $output = [];

        foreach($getGames as $games){
            $category = DB::select("SELECT category.id, category.name FROM category, games, pivot_category WHERE pivot_category.category_id = category.id AND pivot_category.game_id = games.id AND games.id = $games->id");

            $output[] = [
                    'id' => $games->id,
                    'title' => $games->title,
                    'description' => $games->description,
                    'price' => $games->price,
                    'image' => asset($games->image),
                    'category' => $category
                ];
        }

        $categ = $this->getCategory();
        return response()->json(['message' => 'Lets goo!', 'collection' => $output, 'category' => $categ]);
    }

    public function detailGames($id){
        $games = games::where('id', $id)->first();
        $games['image'] = asset($games->image);

        // get categ
        $getCateg = DB::select("SELECT category.name, category.id from category, games, pivot_category WHERE pivot_category.game_id = games.id AND pivot_category.category_id = category.id AND games.id = $id");

        // get gallery
        $getGallery = DB::select("SELECT gallery_games.storage_path from gallery_games, games WHERE games.id = gallery_games.game_id AND games.id = $games->id");

        $getGallery = array_map(function($image){
            return asset($image->storage_path);
        }, $getGallery);

        // get recommend    
        if(count($getCateg) > 0){

            $id_pivot_categ = '';
            foreach($getCateg as $key => $categ){
                if($key < count($getCateg) - 2){
                    $id_pivot_categ .= $categ->id.',';
                }else{
                    $id_pivot_categ .= $categ->id;
                }
            }
            // dd($id_pivot_categ);
            $recomend = DB::select("SELECT games.*, category.name FROM games, pivot_category, category WHERE pivot_category.game_id = games.id And pivot_category.category_id = category.id AND pivot_category.game_id != '$games->id' AND pivot_category.category_id IN ($id_pivot_categ)");   
        }

        // get comments

        $comment = DB::select("SELECT comments.*, users.name from comments,users,games WHERE comments.user_id = users.id AND comments.game_id = games.id AND comments.game_id = $id");

        return response()->json(['detail' => [
            'games' => $games,
            'category' => $getCateg,
            'galleri' => $getGallery,
            'recommended' => isset($recomend) ? $recomend : null,
            'comments' => $comment
        ]]);
    }
    
    public function getCategory(){

        $category = Category::all();
        return $category;
    }
} 