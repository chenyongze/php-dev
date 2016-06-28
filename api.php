<?php
/**
 * Created by PhpStorm.
 * User: chao
 * Date: 16/6/28
 * Time: 上午11:24
 */

define('LOG_PATH',__DIR__);

require "vendor/autoload.php";

$params = file_get_contents("php://input");
$params = json_decode($params,1);

AtsLog::write(0,var_export($params,true));

echo  json_encode($params);