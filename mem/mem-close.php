<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/20
 * Time: 14:25
 */

/* 面向过程 API */
$memcache_obj = memcache_connect('memcache_host', 11211);
/*
do something here ..
*/
memcache_close($memcache_obj);

/* 面向对象 API */
$memcache_obj = new Memcache;
$memcache_obj->connect('memcache_host', 11211);
/*
do something here ..
*/
$memcache_obj->close();



//Memcache::connect() - 打开一个memcached服务端连接
//Memcache::pconnect() - 打开一个到服务器的持久化连接