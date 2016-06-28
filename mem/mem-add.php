<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/20
 * Time: 14:25
 */

$memcache_obj = memcache_connect("localhost", 11211);

/* 面向过程编程 API */
memcache_add($memcache_obj, 'var_key1', 'test variable1', false, 30);


//echo $memcache_obj->get('var_key1');die;
/* 面向对象编程 API */
$memcache_obj->add('var_key2', 'test variable2', false, 30);


echo $memcache_obj->get('var_key2');