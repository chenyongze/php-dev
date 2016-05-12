<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/26
 * Time: 17:49
 */

$client= new GearmanClient();
$client->addServer();


// do()方法是阻塞模式，必须等待worker端返回结果，程序才能停止
$res = $client->do("title", "AASDFGHJX   CVBNVBN");
echo $res."\r\n";


// doBackground()不用等待worker端返回结果，程序就结束了。
$ret = $client->doBackground("title", "AASDFGHJX   CVBNVBN");
var_dump($ret);
