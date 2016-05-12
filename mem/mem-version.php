<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/20
 * Time: 14:25
 */

/* OO API */
$memcache = new Memcache;
$memcache->connect('127.0.0.1', 11211);
echo $memcache->getVersion();

/* procedural API */
$memcache = memcache_connect('127.0.0.1', 11211);
echo memcache_get_version($memcache);