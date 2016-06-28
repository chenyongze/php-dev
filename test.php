<?php
/**
 * Created by PhpStorm.
 * User: chao
 * Date: 16/6/28
 * Time: 上午11:24
 */

define('LOG_PATH',__DIR__);

require "vendor/autoload.php";

$data =$_GET;
//$data =$_POST;
//
//$params = file_get_contents("php://input");
//$params = json_decode($params,1);
//
//$data = $params;

AtsLog::write(0,var_export($data,true));

echo  json_encode($data);

//return json_encode($data);