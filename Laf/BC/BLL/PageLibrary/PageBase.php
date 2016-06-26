<?php
    /**
     * Created by PhpStorm.
     * User: njz
     * Date: 15-2-10
     * Time: 下午6:48
     */

    namespace BC\BLL\PageLibrary;


    /**
     * 全站公有页面基类；所有频道的页面基类必须继承此类；
     * @package BC\BLL\PageLibrary
     */
    class PageBase extends \Controller
    {
        //母板页上需要注意的一些变量；允许被继承；
        public $page_title = '百程旅行网|Baicheng.com';
        public $page_keywords = '百程旅行网';
        public $page_description = '百程旅行网作为中国领先的出境旅游服务公司，为出境游爱好者推荐国外精品旅游线路，旅游线路推荐,跟团旅游等更多旅游信息请访问baicheng.com。';
        public $body_id = '';
        public $body_class = '';
        public $body_width = '';


        //当前登录会员
        public $user = null;
        public $uid = 0;


        public function __construct()
        {
            if (\Session::has('user')) {
                $this->user = \Session::get('user');
                $this->uid = $this->user['uid'];
            }

            //统计信息
            $utmfrom = '2'; //来源方式 默认为web
            $utmsource = '2'; //来源渠道 默认为佰程网站
            $utmsource = intval(\Input::get('utm_source'));
            if (!empty($utmsource)) {
                //\Cookie::make('Byecity_utm_source', $utmsource, 7*24*60);
                setcookie('Byecity_utm_source', $utmsource, 0, '/', '.baicheng.com');
            }
            $utmfrom = intval(\Input::get('utm_from'));
            if (!empty($utmfrom)) {
                //\Cookie::make('Byecity_utm_from', $utmfrom, 7*24*60);
                setcookie('Byecity_utm_from', $utmfrom, 0, '/', '.baicheng.com');
            }
        }

        /**
         * 来源渠道
         *
         * @return mixed
         */
        public function utmsource()
        {
            $utmsource = intval(\Input::get('utm_source')) ;
            if (!empty($utmsource)) {
                setcookie('Byecity_utm_source', $utmsource, 0, '/', '.baicheng.com');
            } else {
                if (!empty($_COOKIE['Byecity_utm_source'])) {
                    $utmsource = intval($_COOKIE['Byecity_utm_source']);
                }
            }

            if (empty($utmsource)) {
                $utmsource = 2;
            }

            return $utmsource;
        }

        /**
         * 来源方式
         *
         * @return mixed
         */
        public function utmfrom()
        {
            $utmfrom = intval(\Input::get('utm_from'));
            if (!empty($utmfrom)) {
                setcookie('Byecity_utm_from', $utmfrom, 0, '/', '.baicheng.com');
            } else {
                if (!empty($_COOKIE['Byecity_utm_from'])) {
                    $utmfrom = intval($_COOKIE['Byecity_utm_from']);
                }
            }
            if (empty($utmfrom)) {
                $utmfrom = 2;
            }
            return $utmfrom;
        }

        /**
         * 验证当前用户有无登录
         * @return bool
         */
        public function BeLogin()
        {
            return isset($this->user) ? true : false;
        }
    }
