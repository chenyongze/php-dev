<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/26
 * Time: 17:49
 */

$client= new GearmanClient();
$client->addServer();


// doNormal()方法是阻塞模式，必须等待worker端返回结果，程序才能停止
$res = $client->doNormal("title", "AASDFGHJXasdsd2222CVBNVBN");
echo $res."\r\n";

// doBackground()不用等待worker端返回结果，程序就结束了。
$ret = $client->doBackground("title", "AASDFGHJX33CVBNVBN");
var_dump($ret);
