<?php
/**
 * Created by PhpStorm.
 * User: chao
 * Date: 16/6/26
 * Time: 下午6:24
 */

namespace App\Controllers;

class Controller{

    public $smarty;

    public function __construct()
    {
        $this->smarty =  new \XBSmarty();
        $this->_init();
    }

    private function _init() {
        $this->smarty->assign('domainName', DOMAIN_NAME);
        $this->_setUri();
    }

    /**
     * 设置URI路径，用以进行标签展示
     * @return [type] [description]
     */
    private function _setUri() {
        $strUri = $_SERVER['REQUEST_URI'];
        $arrUri = explode('?', $strUri);
        $this->smarty->assign("uri", $arrUri[0]);
    }
}