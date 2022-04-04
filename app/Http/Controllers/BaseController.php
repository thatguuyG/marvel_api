<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class BaseController extends Controller
{
    var $url = 'https://gateway.marvel.com:443/v1/public/';


    public function index($offset=0, Request $request) {
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
        $total = $result->data->total;
        if(!isset($result->data)) {
            abort(404);
        }
        $result = $result->data->results;
        return view('welcome', ['result'=>$result, 'offset'=>$offset, 'total'=> $total]);
    }


    // helper functions
    public function generateURL($url) {
        $public_key = '909d40f18a7eccacf364951beb350faf';
        $private_key = '17b826abaf170ac90f90ed55e47616d94c69aacd';

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
