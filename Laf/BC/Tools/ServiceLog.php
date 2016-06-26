<?php
namespace BC\Tools;

class ServiceLog{

    private static $instance = null;
    private static $autoRotate = 0; //是否按小时切分日志

    private function __construct(){
        // 防止类被外部实例化
    }

    // 单例模式
    public static function getInstance(){

        if(!(self::$instance instanceof self)){
            self::$instance = new self;
        }
        return self::$instance;
    }

    // 统计独用
    public static function log($data,$type='info',$fileName='SERVICE'){

        $logPath = storage_path() . '/logs/';
        $logFile = $logPath . date('Y') .'/'. date('Y-m') .'/'. date('Y-m-d') . '-' . $fileName . '.log';
        $dir = dirname($logFile);
        if(!is_dir($dir))
        {
            mkdir($dir,0777,true);
        }
        self::getInstance()->writeLog($data,$logFile,$type);
    }

    // 写Log核心方法
    private function writeLog($data,$logFile,$type='INFO',$depath='1'){

        date_default_timezone_set("PRC");
        $date_time= date('Y-m-d H:i:s');

        $str = '';
        if($type == "WARNING"){
            //$str = json_encode($data);
        }elseif($type == "ERROR"){
            //$str = josn_encode($data);
        }elseif($type == 'INFO'){
            //$str = json_encode($data,true);
        }
        if(is_array($data))
        {
            $str = json_encode($data);
        }
        else
        {
            $str = $data;
        }
        $logInfo = "[$date_time] $type: $str\n";
        file_put_contents($logFile,$logInfo,FILE_APPEND);
    }

}
