<?php
/**
 * Created by PhpStorm.
 * User: wb-bj-dn-245
 * Date: 16/6/24
 * Time: 下午2:43
 */
ini_set('memory_limit', '1280M');
set_time_limit(0);

class imageSyncWorker{

    function __construct() {
        $this->worker     = new GearmanWorker();
        $this->worker->addServer($host = '127.0.0.1', $port = 4730);
    }

    public function imageUploadHandle($job) {
        $data = $job->workload();
        var_dump($data);
        $data          = json_decode($job->workload(), true);
        var_dump($data);
        return $job->workload();
    }

    public function execute() {
        $this->worker->addFunction('imageSync', array($this, 'imageUploadHandle'));
        while ($this->worker->work());
    }
}

$ins = new imageSyncWorker();
$ins->execute();
