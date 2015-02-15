<?php

namespace Weather\Api;


use GuzzleHttp\Client;

class OpenWeatherMapApi {

    private $client;

    public function __construct($client) {
        $this->client = $client;
    }
    function get($location) {

        $url="http://api.openweathermap.org/data/2.5/weather?q=%s";
        $response = $this->client->get(sprintf($url,$location));
        if(!$response||$response->getStatusCode()>=400)
            return false;
        $json = $response->json();
        if($json['cod']>=404)
            return false;
        return $json;

    }
} 