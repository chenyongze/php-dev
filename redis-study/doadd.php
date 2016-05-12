<?php
require('redis.php');

$username = $_POST['username'];
$age = $_POST['age'];
$password = $_POST['password'];

if(empty($username) || empty($password)){
    header('Location:list.php');die;
}

$uid = $redis->incr('userId');

$redis->rPush('userid', $uid);
$res= $redis->hMset('user'.$uid, [
    'uid' => $uid,
    'username' => $username,
    'password' => $password,
    'age' => $age
]);
//
//var_dump($res);
//var_dump($redis->lRange('userid',0,-1));
//var_dump($redis->hGetAll('user'.$uid));die;

$redis->set('username:'.$username,$uid);
header('Location:list.php');
?>
