<?php
    /**
     * Created by PhpStorm.
     * User: njz
     * Date: 15-2-10
     * Time: 下午6:51
     */

    namespace BC\BLL\PageLibrary;
    /**
     * group.baicheng.com的页面基类；该站点下所有动态页面必须继承此类；
     * @package BC\BLL\PageLibrary
     */
    class GroupPageBase extends PageBase {


        public function __construct()
        {
            $this->page_title = '跟团游-'.$this->page_title;
            $this->page_keywords = '跟团游,'.$this->page_keywords;
            $this->page_description = ''.$this->page_description ;
            $this->body_id = ''.$this->body_id;
            $this->body_class = ''.$this->body_class;
            $this->body_width = 'w_1000';
        }

    }
