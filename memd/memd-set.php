<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/21
 * Time: 18:34
 */
$memd = new Memcached();
$memd->addServer('127.0.0.1', 11211);


class demo{
    public $aa;
    protected $bb;
    private $cc;

    public function __construct($aa, $bb, $cc){
        $this->aa = $aa;
        $this->bb = $bb;
        $this->cc = $cc;
    }

    public function aa(){
        return $this->aa;
    }

    protected function bb(){
        return $this->bb;
    }

    private function cc(){
        return $this->cc;
    }

}

/* 'object'这个key将在5分钟后过期 */
$memd->set('array', array(11, 12), time() + 300);
$memd->set('int', 1, time() + 300);
$memd->set('str', "aaa", time() + 300);
$memd->set('obj', new demo(1,2,3) , time() + 300);
var_dump($memd->get('array'));
var_dump($memd->get('int'));
var_dump($memd->get('str'));
var_dump($memd->get('obj'));
