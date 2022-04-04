<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;


class MarvelCharacters extends Controller
{
    var $url = 'https://gateway.marvel.com:443/v1/public/';

    public function index() {
        $url = $this->url.'characters?';
        $base_controller = new BaseController();
        $result = json_decode($base_controller->makeRequest($url));
        if(!isset($result->data)) {
            abort(404);
        }
        $result = $result->data->results;
        return $result;
    }

    public function characterById($id) {
        $url = $this->url.'characters/'.$id .'?';
        $base_controller = new BaseController();
        $result = json_decode($base_controller->makeRequest($url));
        if(!isset($result->data)) {
            abort(404);
        }
        $result = $result->data->results;
        return view('character', ['result'=>$result]);
    }


    public function comicByCharacterById($id) {
        $url = $this->url.'characters/'.$id .'/comics?';
        $base_controller = new BaseController();
        $result = json_decode($base_controller->makeRequest($url));
        if(!isset($result->data)) {
            abort(404);
        }
        $result = $result->data->results;
        return $result;
    }

    public function eventByCharacterById($id) {
        $url = $this->url.'characters/'.$id .'/events?';
        $base_controller = new BaseController();
        $result = json_decode($base_controller->makeRequest($url));
        if(!isset($result->data)) {
            abort(404);
        }
        $result = $result->data->results;
        return $result;
    }


    public function seriesByCharacterById($id) {
        $url = $this->url.'characters/'.$id .'/series?';
        $base_controller = new BaseController();
        $result = json_decode($base_controller->makeRequest($url));
        if(!isset($result->data)) {
            abort(404);
        }
        $result = $result->data->results;
        return $result;
    }

    public function storiesByCharacterById($id) {
        $url = $this->url.'characters/'.$id .'/stories?';
        $base_controller = new BaseController();
        $result = json_decode($base_controller->makeRequest($url));
        if(!isset($result->data)) {
            abort(404);
        }
        $result = $result->data->results;
        return $result;
    }

}




