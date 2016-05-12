<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/20
 * Time: 14:25
 */



//string Memcache::get ( string $key [, int &$flags ] )
//array Memcache::get ( array $keys [, array &$flags ] )



/* procedural API */
$memcache_obj = memcache_connect('127.0.0.1', 11211);
$var = memcache_get($memcache_obj, 'some_key');

/* OO API */
$memcache_obj = new Memcache;
$memcache_obj->connect('127.0.0.1', 11211);
$var = $memcache_obj->get('some_key');

/*
你同样可以使用数组key作为参数，如果某个元素没有在服务端发现，结果数组中将不会包含这些key。
*/

/* procedural API */
$memcache_obj = memcache_connect('127.0.0.1', 11211);
$var = memcache_get($memcache_obj, Array('some_key', 'another_key'));

/* OO API */
$memcache_obj = new Memcache;
$memcache_obj->connect('127.0.0.1', 11211);
$var = $memcache_obj->get(Array('some_key', 'second_key'));
