<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class BaseController extends Controller
{
    var $url = 'https://gateway.marvel.com:443/v1/public/';


    public function index($offset=0) {
        $url = $this->url .'characters?offset='. $offset.'&';
        $result = json_decode($this->makeRequest($url));
        if(!isset($result->data)) {
            abort(404);
        }
        $total = $result->data->total;
        $result = $result->data->results;
        Cache::forever('mainResults', $result);
        return view('welcome', ['result'=>$result, 'offset'=>$offset, 'total'=>$total]);
    }

    public function search() {
        $offset = 0;
        $name = $_GET['name'];
        if ($name == '') {
            $url = $this->url .'characters?offset='. $offset.'&';
        } else {
            $url = $this->url .'characters?nameStartsWith='. $name.'&';
        }

        $result = json_decode($this->makeRequest($url));
        if(!isset($result->data)) {
            abort(404);
        }
        $total = $result->data->total;
        if ($total > 0) {
            $result = $result->data->results;
            return view('welcome', ['result'=>$result, 'offset'=>$offset, 'total'=> $total]);
        }

        return view('nodata');
    }


    // helper functions
    public function generateURL($url) {
        $public_key = config('services.marvel.public_key');
        $private_key = config('services.marvel.private_key');

        $ts= time();
        $hash = md5($ts.$private_key.$public_key);

        return $url . '&apikey='. $public_key. '&ts='.$ts.'&hash='.$hash;
    }

    public function makeRequest($url) {
        $curl = curl_init();

        $data_url = $this->generateURL($url);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $data_url
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}