<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/20
 * Time: 21:03
 */


//$Memcached = new ReflectionClass("Memcached");
//var_dump($Memcached->getMethods());


$servers = array(
    array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 1),
    array('host' => '127.0.0.1', 'port' => 11212, 'weight' => 2),
);

$memd = new Memcached();
$memd->setOption(\Memcached::OPT_LIBKETAMA_COMPATIBLE, true);
$memd->setOption(\Memcached::OPT_CONNECT_TIMEOUT, 100);
$memd->setOption(\Memcached::OPT_POLL_TIMEOUT, 100);
$memd->addServers($servers);


//获取所有的key
//var_dump($memd->getAllKeys());
//作废缓存中的所有元素
//$memd->flush();

//var_dump($memd->getVersion()) ;

/*
 * OPT_COMPRESSION
开启或关闭压缩功能。当开启的时候，item的值超过某个阈值（当前是100bytes）时，会首先对值进行压缩然后存储，并 在获取该值时进行解压缩然后返回，使得压缩对应用层透明。
类型: boolean, 默认: TRUE.
 */
$memd->setOption(Memcached::OPT_COMPRESSION, false);
$memd->set('foo', 'abc');
$memd->append('foo', 'def');
var_dump($memd->get('foo'));