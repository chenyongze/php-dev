<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/21
 * Time: 17:57
 */


$m = new Memcached();
$m->addServer('127.0.0.1', 11211);

$m->flush();

$ips = array($_SERVER['REMOTE_ADDR']);
$m->add('ip_block', $ips);

//$m->get('aa');

var_dump($m->getResultCode());
var_dump($m->getResultMessage());

var_dump($m);

?>