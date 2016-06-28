<?php
require('redis.php');
//总记录数
$count = $redis->lSize('userid');

//当前页数
$page_num = isset($_GET['page']) ? $_GET['page'] : 1;

//每页多少条数据
$page_size = 3;
//总页数
$num = ceil($count / $page_size);

$ids = $redis->lRange('userid', ($page_num-1)*$page_size, ($page_num-1)*$page_size + $page_size-1);

foreach ($ids as $id)
{
    $data[] = $redis->hGetAll('user'.$id);
}

var_dump($data);

?>

<a href="add.php" >注册</a>
<?php
    if (!empty($_COOKIE['auth'])) {


    $auth = $_COOKIE['auth'];
        $id = $redis->get('auth:'.$auth);
        $name = $redis->hget('user'.$id, 'username');
?>
        欢迎您 <?php echo $name;?>
        <a href="logout.php">退出</a>



 <?php
    } else {
?>
<a href="login.php">登陆</a>
<?php } ?>
<table border="1">
    <tr>
        <th>uid</th>
        <th>用户名</th>
        <th>年龄</th>
        <th>操作</th>
    </tr>
<?php foreach ($data as $v) {?>
<tr>
    <td><?php echo $v['uid'];?></td>
    <td><?php echo $v['username'];?></td>
    <td><?php echo $v['age'];?></td>
    <td>
        <a href="edit.php?uid=<?php echo $v['uid'];?>" >编辑</a>
        <a href="del.php?uid=<?php echo $v['uid'];?>">删除</a>
        <?php if (!empty($_COOKIE['auth']) && $v['uid'] != $id) { ?>
        <a href="addfans.php?uid=<?php echo $v['uid'];?>&id=<?php echo $id;?>">加关注</a>
        <?php }?>
    </td>
</tr>

    <?php } ?>

    <?php
        for ($i=1; $i<=$num; $i++)
        {
            echo '<a href="list.php?page='.$i.'">'.$i.'</a>';
        }

    ?>
</table>

<p>我关注的人</p>
<table border="1">
    <?php
        $datas = $redis->sMembers('user:'.$id.':following:');
        foreach ($datas as $data) {
            $user = $redis->hGetAll('user'.$data);
    ?>
    <tr>
        <td><?php echo $user['username'];?></td>
    </tr>

<?php }?>

</table>