<?php
/**
 * Created by PhpStorm.
 * User: wb-bj-dn-245
 * Date: 16/6/24
 * Time: 下午2:50
 */


$client= new GearmanClient();
$client->addServer($host = '127.0.0.1', $port = 4730);


$arrInput['localFileName'] = "/data/img/1.jpg";
$arrInput['fileName']      = "aaaa";

$res = $client->doNormal('imageSync', json_encode($arrInput));

var_dump($res);