<?php
require('redis.php');

$uid = $_GET['uid'];
$id = $_GET['id'];
$redis->sadd('user:'.$id.':following:', $uid);
$redis->sadd('user:'.$uid.':followers:', $id);
header('Location:list.php');
?>
