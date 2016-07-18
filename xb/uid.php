<?php
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
set_time_limit(0);

// 连接数据库
$con = mysql_connect("10.2.1.124:3307", "wenba", "wenbatest");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}


// 获得用户课程
function getUserLessons(){
    // 选择库
    mysql_select_db("liveuser");
    mysql_query("SET NAMES 'utf8'");

    $where = " where status !=2 ";
    $sql = "select * from user_lessons".$where;
    $res = mysql_query($sql);
    $data = [];
    while($tmp_arr =  mysql_fetch_assoc($res))
    {
        $data[] = $tmp_arr;
    };
    return $data;
}


$data = getUserLessons();
//echo count($data);die;
//var_dump($data);die;
$res = import_data($data);
echo "查询条数:".count($data).'-----插入条数:'.count($res);


// task 导入用户
function import_data($data){
    $ids= [];
    foreach ($data as $k => $v) {
        $id = insert_task($v);
        $ids[] = $id;
    }
    return $ids;
}

// 插入作业
function insert_task($data)
{
    $userId = $data['uid'];
    $roomId = $data['roomId'];
    $classId = $data['classId'];
    $createTime = $data['createTime'];

    mysql_select_db("wenba_live");
    mysql_query("SET NAMES 'utf8'");

    $sql = "INSERT INTO wenba_live_user_task (userId, roomId, classId, createTime, updateTime) VALUES ('{$userId}', '{$roomId}', '{$classId}',{$createTime}, {$createTime})";
    mysql_query($sql);
    return mysql_insert_id();
}
