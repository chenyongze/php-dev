<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/20
 * Time: 14:25
 */
/* procedural API */

/* connect to memcached server */
$memcache_obj = memcache_connect('127.0.0.1', 11211);

/*
设置'var_key'对应存储的值
flag参数使用0,值没有经过压缩
失效时间为30秒
*/
echo memcache_set($memcache_obj, 'var_key1', 'some variable', 0, 30);

echo memcache_get($memcache_obj, 'var_key1');


/* OO API */

$memcache_obj = new Memcache;

/* connect to memcached server */
$memcache_obj->connect('127.0.0.1', 11211);

/*
设置'var_key'对应值，使用即时压缩
失效时间为50秒
*/
echo $memcache_obj->set('var_key2', 'some really big variable', MEMCACHE_COMPRESSED, 50);

echo $memcache_obj->get('var_key2');
