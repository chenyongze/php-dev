<?php
/**
 *
 * 获取当前项目运行的环境
 */
namespace BC\Tools;
use Illuminate\Support\Facades\Config;
class Envirement {


    public static $ENVS = array('dev', 'test', 'preonline', 'online');

    /**
     * 获取当前项目运行的环境
     *  return dev, test, preonline, online
     */

    public static function getEnv() {
        // 优先读取用户配置是什么环境
        $configEnv = Config::get('app.env');
        if (!empty($configEnv)) {
            return $configEnv;
        }

        global $env;
        return in_array($env, self::$ENVS) ? $env : 'dev';
    }

    /**
     *
     * 返回项目在服务器上项目名称
     * 或者抛出异常
     */
    public static function getProject() {

        $file = $_SERVER['SCRIPT_FILENAME'];

        if (empty($file)) {
            $message = '没有$_SERVER["SCRIPT_FILENAME"]变量';
            throw new \Exception($message, 1000001);
        }
        
        $project = basename(dirname(dirname($file)));
        return $project;
        /*
        $pregs = array('#\/var\/www\/html\/([a-z0-9A-Z_.]+)\/.*#', '#\/home\/bc\/([a-z0-9A-Z_.]+)\/.*#');

        $pregConfig = Config::get('app.projectPreg');
        if (!empty($pregConfig)) {
            $pregConfig = is_array($pregConfig) ? $pregConfig : array($pregConfig);
            $pregs = array_merge($pregs, $pregConfig);
        }

        foreach ($pregs as $preg) {
            $isMatch = preg_match($preg, $file, $matches);
            if ($isMatch) {
                return $matches[1];
            }
        }

        $message = "在/var/www/html或者/home/bc或者用户自定义路径 下没找到项目";
        throw new \Exception($message, 1000001);
        */
    }
}