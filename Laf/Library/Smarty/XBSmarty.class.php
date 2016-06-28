<?php
require_once __DIR__ . '/Smarty.class.php';
class XBSmarty extends Smarty {
    public function __construct(){
        parent::__construct();

        $this->caching = 0;
        $this->left_delimiter = '<{';
        $this->right_delimiter = '}>';
        $this->compile_check = true;
        $this->force_compile = false;

        $this->caching = false;                             //是否使用缓存
        $this->setTemplateDir(APP_PATH . '../views/');      //设置模板目录
        $this->setCompileDir(APP_PATH . '/Storage/template_c/');    //设置编译目录
        $this->setConfigDir(APP_PATH . 'config/smarty/');
        $this->setCacheDir(APP_PATH . 'cache/smarty/');     //缓存文件夹
    }

    public function display($template = null, $cache_id = null, $compile_id = null, $parent = null){
//        $ci =& get_instance();
//        $ci->render = 'html';
        call_user_func_array('parent::display', func_get_args());
    }
}
