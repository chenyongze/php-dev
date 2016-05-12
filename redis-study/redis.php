<?php
$redis = new Redis();
$result = $redis->connect('127.0.0.1', 6379);
$redis->auth('lychao');

function dd($data=''){
    var_dump($data);
//    die;
}