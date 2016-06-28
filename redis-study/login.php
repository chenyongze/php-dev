<?php
require('redis.php');



if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $id = $redis->get('username:'.$username);


    if (!empty($id)) {
        $pass = $redis->hGet('user'.$id,'password');
        if ($pass == $password) {
            $auth = md5(time().$username.rand());
            $redis->set('auth:'.$auth, $id );
            setcookie('auth', $auth, time()+86400);
            header('Location:list.php');
        }
    }
}


?>


<form action="" method="post">
    用户名:<input type="text" name="username" /><br>
    密码:<input type="password" name="password" /><br>
    <input type="submit" name="submit" value="提交" >

</form>
