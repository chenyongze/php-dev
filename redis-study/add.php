<?php
require('redis.php');

?>
<form action="doadd.php" method="post">
    用户名:<input type="text" name="username" /><br>
    密码:<input type="password" name="password" /><br>
    年龄:<input type="text" name="age" />
    <input type="submit" value="提交" >

</form>
