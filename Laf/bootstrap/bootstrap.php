<?php
/**
 * Created by PhpStorm.
 * User: wb-bj-dn-245
 * Date: 16/6/27
 * Time: 下午2:44
 */

use Illuminate\Database\Capsule\Manager as Capsule;


// 引入自定义配置文件
require APP_PATH."/Config/common.php";
require APP_PATH."/Helpers/common.php";




// Autoload 自动载入
require BASE_PATH.'/vendor/autoload.php';




// Eloquent ORM
$capsule = new Capsule;
$capsule->addConnection(require APP_PATH.'/config/database.php');
$capsule->bootEloquent();




// whoops 错误提示
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();