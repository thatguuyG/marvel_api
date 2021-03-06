<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;

class MarvelComics extends Controller
{
    var $url = 'https://gateway.marvel.com:443/v1/public/';

    public function index($id) {
        $url = $this->url.'comics/'.$id .'?';
        $base_controller = new BaseController();
        $result = json_decode($base_controller->makeRequest($url));
        if(!isset($result->data)) {
            abort(404);
        }
        $result = $result->data->results;
        return view('comic', ['result'=>$result]);
    }

    public static function getComicImg ($id) {
        $base_url = 'https://gateway.marvel.com:443/v1/public/';
        $url = $base_url.'comics/'.$id .'?';
        $base_controller = new BaseController();
        $result = json_decode($base_controller->makeRequest($url));
        if(!isset($result->data)) {
            abort(404);
        }
        $result = $result->data->results;
        foreach ($result as $r) {
            $path_exists = isset($r->images[0]->path);
            $extension_exists = isset($r->images[0]->extension);
            if ($path_exists && $extension_exists) {
                return $r->images[0]->path.'.'.$r->images[0]->extension;
            }
            return false;
        }
    }
}