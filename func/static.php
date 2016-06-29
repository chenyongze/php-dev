<?php
function Test()
{
    static $w3sky = 0;
    echo $w3sky;
    $w3sky++;
}


Test();
Test();
Test();



//try{
//    throw new \Exception('汇付天下签名服务连接失败');
//}catch (Exception $e){
//    echo 11;
//}
