<?php
ini_set('memory_limit', '1280M');
set_time_limit(0);

$worker= new GearmanWorker();
$worker->addServer();
$worker->addFunction("title", "title_function");
while ($worker->work());

function title_function($job)
{
    // 接收数据
    $tmp = $job->workload();

    // 处理
//    echo $tmp."\r\n";
    return strtolower($tmp);
}
