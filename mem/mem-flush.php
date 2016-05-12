<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/20
 * Time: 14:25
 */
//Memcache::flush — 清洗（删除）已经存储的所有的元素
//bool Memcache::flush ( void )
//成功时返回 TRUE， 或者在失败时返回 FALSE。


/* procedural API */
$memcache_obj = memcache_connect('memcache_host', 11211);

memcache_flush($memcache_obj);

/* OO API */

$memcache_obj = new Memcache;
$memcache_obj->connect('memcache_host', 11211);

$memcache_obj->flush();
