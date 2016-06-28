<?php
require('redis.php');
$uid = $_POST['uid'];
$username = $_POST['username'];
$age = $_POST['age'];

$redis->hMset('user'.$uid, [
    'uid' => $uid,
    'username' => $username,
    'age' => $age
]);
header('Location:list.php');
?>
