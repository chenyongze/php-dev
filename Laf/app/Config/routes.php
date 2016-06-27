<?php
/**
 * Created by PhpStorm.
 * User: wb-bj-dn-245
 * Date: 16/6/27
 * Time: 上午10:14
 */

use NoahBuscher\Macaw\Macaw;


Macaw::get('fuck', function() {
    echo "成功！";
});


Macaw::get('test', '\App\Controllers\TestController@index');
Macaw::get('api', '\App\Controllers\ApiController@index');
Macaw::get('home', '\App\Controllers\ArticleController@home');
Macaw::get('view', '\App\Controllers\ArticleController@view');

//
//Macaw::get('(:all)', function($fu) {
//    echo "<h1>Hello Laf !</h1>";
//});

//Macaw::error(function() {
//    echo '404 :: Not Found';
//});


Macaw::$error_callback = function() {
    throw new Exception("路由无匹配项 404 Not Found");
};


Macaw::dispatch();