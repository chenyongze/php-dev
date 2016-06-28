<?php
$memcache = new Memcache;
$memcache->connect('127.0.0.1',11211);
$memcache->set('key','hello memcache!');
$out = $memcache->get('key');
echo $out;


/* procedural API */
$memcache_obj = memcache_pconnect('127.0.0.1', 11211);
var_dump($memcache_obj);
/* OO API */

$memcache_obj = new Memcache;
$memcache_obj->pconnect('127.0.0.1', 11211);
var_dump($memcache_obj);




//打开一个memcached服务端连接
/* procedural API */

$memcache_obj = memcache_connect('memcache_host', 11211);

/* OO API */

$memcache = new Memcache;
$memcache->connect('memcache_host', 11211);



// Memcache::pconnect()和 Memcache::connect()非常类似，不同点在于这里建立的连接是持久化的。
// Memcache::connect()打开的连接在脚本执行结束后会自动关闭。当然，你也可以使用方法 Memcache::close()来主动关闭
// 同样你也可以使用函数memcache_pconnect()。