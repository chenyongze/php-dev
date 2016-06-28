<?php

class Cache
{
    //线上配置文件
    private static $online = array(
        array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 1),
    );

    //配置文件测试环境
    private static $test = array(
        array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 1),
    );

    //获取缓存实例
    private static $obj;
    private static $prefix; //前缀
    private static function obj()
    {
        if(!isset(self::$obj)){
            self::$obj = new \Memcached();
            $serverList = self::$obj->getServerList();
            if(empty($serverList)){
                self::$obj->setOption(\Memcached::OPT_LIBKETAMA_COMPATIBLE, true);  //持久化处理
                self::$obj->setOption(\Memcached::OPT_CONNECT_TIMEOUT, 100);
                self::$obj->setOption(\Memcached::OPT_POLL_TIMEOUT, 100);
                //正式
                if(trim($_SERVER['ENV'])=='online'){
                    self::$prefix = 'online';
                    self::$obj->addServers(self::$preonline);
                }elseif(trim($_SERVER['ENV'])=='test'){
                    self::$prefix = 'test';
                    self::$obj->addServers(self::$test);
                }else{
                    self::$prefix = '';
                    self::$obj->addServers(self::$test);
                }
            }
        }
        return self::$obj;
    }

    //获取
    public static function get($key)
    {
        return self::obj()->get(self::$prefix.trim($key));
    }

    //设置 $time 秒
    public static function set($key,$val,$time=0)
    {
        return self::obj()->set(self::$prefix.trim($key),$val,(int)$time);
    }

    /**
     *
     * 设置或者获取web端所有缓存键； 方便管理；
     * @return array
     */
    public static function AllCacheKey()
    {
        return self::obj()->getAllKeys();
    }

}