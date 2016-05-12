<?php
require('redis.php');
$uid = $_GET['uid'];
$user = $redis->hGetAll('user'.$uid);
var_dump($user);
?>

<form action="doedit.php" method="post">
    <input type="hidden" value="<?php echo $user['uid'];?>" name="uid"/>
    用户名:<input type="text" name="username" value="<?php echo $user['username']?>"/><br>
    年龄:<input type="text" name="age"  value="<?php echo $user['age']?>"/>
    <input type="submit" value="修改" >

</form>
