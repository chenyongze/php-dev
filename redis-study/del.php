<?php
require('redis.php');

$uid = $_GET['uid'];
$redis->delete('user'.$uid);

$redis->lRem('userid', $uid);
header('Location:list.php');
?>

