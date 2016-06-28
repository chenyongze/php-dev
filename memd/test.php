<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/21
 * Time: 18:19
 */

include("cache.php");

$arr = [
    'a'=>111,
    'b'=>222,
    'c'=>[333,444]
];

Cache::set('key1',$arr,60);

var_dump(Cache::get('key1'));


var_dump(Cache::AllCacheKey());
