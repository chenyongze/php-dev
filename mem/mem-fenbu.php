<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/20
 * Time: 16:30
 */

$mem = new Memcache;

$mem->addServer('localhost', 11213);
$mem->addServer('localhost', 11214);
$mem->addServer('localhost', 11215);

//$version = $mem->getVersion();     //返回服务器版本信息
//var_dump($version);

////$stats = $mem->getStats();       //获取服务器统计信息
////var_dump($stats);
//$res = $mem->getServerStatus('localhost', 11213);  //用于获取一个服务器的在线/离线状态
////var_dump($res);


$memStats = $mem->getExtendedStats();  //缓存服务器池中所有服务器统计信息
//var_dump($memStats);

mysql_connect("localhost", "vagrant", "") or die(mysql_error());
mysql_select_db("test") or die(mysql_error());

$query = "select * from user";
$querykey = "KEY" . md5($query);

$result = $mem->get($querykey);

if (!$result) {
    $res = mysql_query($query);
    while($row = mysql_fetch_assoc($res)){
        $result[] = $row;
    }

    $mem->set($querykey, $result, 0, 600);
}

var_dump($result);






