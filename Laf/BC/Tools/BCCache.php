<?php
/**
 * Created by PhpStorm.
 * User: baicheng
 * Date: 15-3-9
 * Time: 下午3:15
 */

namespace BC\Tools;

class BCCache
{
    //预上线配置文件
    private static $preonline = array(
        array('host' => '192.168.3.21', 'port' => 13000, 'weight' => 1),

    );
    //线上配置文件
    private static $online = array(
        array('host' => '192.168.3.21', 'port' => 13000, 'weight' => 1),

    );
	
	//配置文件测试环境
    private static $test = array(
        array('host' => '192.168.28.213', 'port' => 13000, 'weight' => 1),
    );

    //获取缓存实例
    private static $obj;
    private static $prefix; //前缀
    private static function obj()
    {
        if(!isset(self::$obj)){
            self::$obj = new \Memcached(); //持久化处理 'Cache_baicheng'
            $serverList = self::$obj->getServerList();
            if(empty($serverList)){
                self::$obj->setOption(\Memcached::OPT_LIBKETAMA_COMPATIBLE, true);
                self::$obj->setOption(\Memcached::OPT_CONNECT_TIMEOUT, 100);
                self::$obj->setOption(\Memcached::OPT_POLL_TIMEOUT, 100);
                //正式
                if(trim($_SERVER['BC_ENV'])=='online'){
                    self::$prefix = 'online';
                    self::$obj->addServers(self::$preonline);
                }
                //预上线
                if(trim($_SERVER['BC_ENV'])=='preonline'){
                    self::$prefix = 'preonline';
                    self::$obj->addServers(self::$online);
                }
				
				//测试环境
                if(trim($_SERVER['BC_ENV'])=='test'){
                    self::$prefix = 'test';
                    self::$obj->addServers(self::$test);
                }
            }
        }
        return self::$obj;
    }

    //获取
    public static function get($key)
    {
        if(!in_array($_SERVER['BC_ENV'],array('preonline','online')) && count(self::$test) == 0){
            return NULL;
        }

        return self::obj()->get(self::$prefix.trim($key));
    }

    //设置
    public static function set($key,$val,$time=0)
    {
        if(!in_array($_SERVER['BC_ENV'],array('preonline','online')) && count(self::$test) == 0){
            return false;
        }

        return self::obj()->set(self::$prefix.trim($key),$val,(int)$time);
    }

    /**
     *
     * 设置或者获取web端所有缓存键； 方便管理；
     *
     * @param $keyname
     *
     * @return bool
     */
    public static function AllCacheKey($keyname='')
    {
        $allcachekey = 'allcachekey';
        if(empty($keyname))
        {
            return self::obj()->get($allcachekey);
        }
        //检测要写入的值 是否在原有值里已经出现过，如果出现过，则直接返回；否则将此值 追加到末尾处
        if( strpos( self::obj()->get($allcachekey),$keyname)===false)
        {
            $v = self::obj()->get($allcachekey) . ';' .  $keyname;
            return self::obj()->set($allcachekey,$v,0);
        }
        else
        {
            return true;
        }
    }

}