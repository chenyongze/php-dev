<?php
/**
 * Created by PhpStorm.
 * User: wang hao
 * Create Time: 14-9-17 18:34
 * Modify Time: 14-9-17 18:34
 */

namespace BC\Search;

class Engine
{
    private static $config = array(
        'host'=>'192.168.3.149',
        'port'=>9312,
        'outtime'=>3, //超时秒数
    );

    //获取搜索器
    private static $obj;
    private static function obj()
    {
        if(!isset(self::$obj)){
            $cl = new SphinxClient(); //创建Sphinx的客户端接口对象
            $cl->SetServer(self::$config['host'],self::$config['port']); //设置连接Sphinx主机名与端口
            $cl->SetMatchMode(SPH_MATCH_ALL); //设定搜索模式
            $cl->SetArrayResult(true);
            $cl->SetMaxQueryTime((int)self::$config['outtime']*1000); //查询超时10s
            self::$obj = $cl;
        }
        return self::$obj;
    }

    //获取分词结果
    public static function getKeywords($text,$index)
    {
        $data = self::obj()->BuildKeywords($text,$index,false);
        $keywords = array();
        foreach($data as $d){
            $key = trim($d['tokenized']);
            !empty($key) && $keywords[] = $key;
        }
        return $keywords;
    }

    //基础搜索方法
    //参数：$index 索引，$keyword 搜索关键字,$sortby 排序子句, $page 当前页码, $length 每页显示记录数
    public static function get($index,$keyword,$sortby='',$page=1,$length=20)
    {
        $page = (int)$page;
        $page < 1 && $page = 1;
        $start = ($page-1)*$length;

        $sortby = trim($sortby);
        empty($sortby) && $sortby = '@weight DESC, @id DESC';

        $obj = self::obj();
        $obj->SetSortMode(SPH_SORT_EXTENDED,$sortby); //排序 '@weight DESC, @id DESC'
        $obj->SetFieldWeights(array('title'=>2,'content'=>1));
        $obj->SetLimits($start,$length,1000); //最多搜索1w条数据,服务端的配置文件中的对应项至少要大于1w
        $data = $obj->Query($keyword,$index);

        return $data;
    }


}