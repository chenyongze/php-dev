<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/20
 * Time: 14:25
 */


/* procedural API */
$memcache_obj = memcache_connect('127.0.0.1', 11211);

/* 10秒后key_to_delete对应的值会被从服务端删除 */
memcache_delete($memcache_obj, 'key_to_delete', 10);

/* OO API */
$memcache_obj = new Memcache;
$memcache_obj->connect('127.0.0.1', 11211);

$memcache_obj->delete('key_to_delete', 10);
