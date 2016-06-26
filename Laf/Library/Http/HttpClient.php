<?php
use Guzzle\Http\Client;
/**
 * Created by PhpStorm.
 * User: chao
 * Date: 16/6/26
 * Time: 下午5:09
 */
class HttpClient{

    public static function get($uri, $headers = array(), $options = array()){
        $client = new Client();

        $response = $client->get(
            $uri,
            $headers,
            $options
        )->send();

        return $response->getBody(true);
    }


    public static function post($uri, $headers = array(), $postBody = array(), $options = array()){
        $client = new Client();

        $response = $client->post(
            $uri,
            $headers,
            $postBody,
            $options
        )->send();

        return $response->getBody(true);
    }


}

