<?php
/**
 * Created by PhpStorm.
 * User: njz
 * Date: 14-9-25
 * Time: 下午4:04
 */

namespace BC\Tools;


class URLHelper
{
    public static $env_list = ['online','preonline','test','local'];
    public static $sub_domain_list = ['visa','dujia','jiesongji','tickets','yiriyou','shopping'];
    #region 生成h5静态连接地址方法

    private static $sUrl_h5 = array(
        'test'=>'http://m123.baicheng.com/h5_v151', //测试环境的静态文件http://builder.baicheng.com/html5test/h5_v151
        'online'=>'http://static.baicheng.com/h5', //正式环境的静态文件
    );
    /*
     * 组装静态文件URL路径
     * 参数: $path 静态文件的相对路径
     */
    public static function sUrl_h5($path)
    {
        $h = trim(isset($_SERVER['BC_ENV'])?$_SERVER['BC_ENV']:'dev');
        empty($h) && $h = 'dev';
        $path = trim($path);
        $path{0} !='/' && $path = '/'.$path;

        if(in_array($h,array('test','dev','preonline','local','online'))){
            $path = str_replace('/online/','/pages/',$path);
            return self::$sUrl_h5['test'].$path;
        }else{
            $path = str_replace('/pages/','/online/',$path);
            return self::$sUrl_h5['online'].$path.'?v=2.0';
        }
    }

    #endregion


    #region 生成PC静态连接地址方法
    //配置静态文件url前缀
    private static $sUrl = array(
        'test'=>'http://builder.baicheng.com/release20150116', //测试环境的静态文件
        'online'=>'http://static.baicheng.com', //正式环境的静态文件
    );
    /*
     * 组装静态文件URL路径
     * 参数: $path 静态文件的相对路径
     */
    public static function sUrl($path)
    {
        $h = trim(isset($_SERVER['BC_ENV'])?$_SERVER['BC_ENV']:'dev');
        empty($h) && $h = 'dev';
        $path = trim($path);
        $path{0} !='/' && $path = '/'.$path;

        if(in_array($h,array('test','dev','local','preonline'))){
            $path = str_replace('/online/','/pages/',$path);
            return self::$sUrl['test'].$path;
        }else{
            $path = str_replace('/pages/','/online/',$path);
            return self::$sUrl['online'].$path.'?v=1.7';
        }
    }
    #endregion

    //配置url模板 - 使用重载方法
    //即：下面数组的key为方法名, val中的问号为占位符，第一个占位符自动写入，从第二个开始为传入方法的参数
    //返回填充之后的完整url
    //点位符 ? 问号
    private static $urlTplArr  = array(
        //网站首页
        'home'=>'http://www?.baicheng.com', //首页

        //签证
        'visaIndex'=>'http://visa?.baicheng.com', //签证首页
        'customizedTravel'=>'http://www?.baicheng.com/customized', //签证首页
        'huiTravel'=>'http://zt.baicheng.com/travel_hui/travel.html', //惠旅行
        'visaList'=>"http://visa?.baicheng.com/?-?.html",//签证列表页, 参数: 国家ID, 省份ID
        'visaInfo'=>'http://visa?.baicheng.com/product_?.html', //签证终端页, 参数: sku码
        'visaCountryImg'=>'http://visa?.baicheng.com/static/images/countrys/logo_?.png', //签证国家的图片
        'visaCountryDetail'=>'http://visa?.baicheng.com/country_?_?.html', //签证国家的详情页

        //自由行
        'packageIndex'=>'http://dujia?.baicheng.com/package', //自由行首页
        'packageList'=>'http://dujia?.baicheng.com/package/?-?-?-?/p?/?',  //跟团游筛选列表页, 参数:{天数}-{出发城市}-{国家}-{城市}/{分页}
        'packageInfo'=>'http://dj?.baicheng.com/package/?.html', //自由行终端页, 参数: {sku码}

        //跟团游
        'groupIndex'=>'http://dujia?.baicheng.com/group', //跟团游首页
        'groupList'=>'http://dujia?.baicheng.com/group/?-?-?-?/p?/?',  //跟团游筛选列表页, 参数:{天数}-{出发城市}-{国家}-{城市}/{分页}/参数
        'groupInfo'=>'http://dj?.baicheng.com/group/?.html', //跟团游终端页 参数: {sku码}

        //海外租车
        'izucheIndex'=>'http://izuche?.baicheng.com', //租车首页
        'izucheList'=>'http://izuche?.baicheng.com/?/?', //租车筛选列表 参数: {品类id} {分页属性}
        'izucheInfo'=>'http://izuche?.baicheng.com/?.html', //租车终端页, 参数: {SKU码}

        //单项
        'singleClientinfo'=>'http://g?.baicheng.com/single/order/clientinfo/?', //门票首页 {主单ID}

        //门票
        'ticketsIndex'=>'http://tickets?.baicheng.com', //门票首页
        'ticketsList'=>'http://tickets?.baicheng.com/?/?', //门票筛选列表 参数: {品类id} {分页属性}
        'ticketsInfo'=>'http://tickets?.baicheng.com/?.html', //门票终端页 参数: {sku码}
        'ticketsTraveller'=>'http://tickets?.baicheng.com/traveller/?-?', //门票订单完善客人信息页 参数: {主单ID}{产品ID}
        'ticketsTravellerSuccess'=>'http://tickets?.baicheng.com/traveller-success/?-?', //门票订单完善客人信息成功页 参数: {主单ID}{产品ID}
        'ticketsOrderDetail'=>'http://tickets?.baicheng.com/single/order/detail/?/?', //门票订单详情页 参数: {主单ID}{产品ID}

        //一日游
        'yiriyouIndex'=>'http://yiriyou?.baicheng.com', //一日游首页
        'yiriyouList'=>'http://yiriyou?.baicheng.com/?/?', //一日游筛选列表 参数: {品类id} {分页属性}
        'yiriyouInfo'=>'http://yiriyou?.baicheng.com/?.html', //一日游终端页 参数: {sku码}
        'yiriyouTraveller'=>'http://yiriyou?.baicheng.com/traveller/?-?', //日游订单完善客人信息页 参数: {主单ID}{产品ID}
        'yiriyouTravellerSuccess'=>'http://yiriyou?.baicheng.com/traveller-success/?-?', //yiriyou订单完善客人信息成功页 参数: {主单ID}{产品ID}
        'yiriyouOrderDetail'=>'http://yiriyou?.baicheng.com/single/order/detail/?/?', //yiriyou订单详情页 参数: {主单ID}{产品ID}

        //接送机
        'jiesongjiIndex'=>'http://jiesongji?.baicheng.com', //接送机首页
        'jiesongjiList'=>'http://jiesongji?.baicheng.com/?/?', //接送机筛选列表 参数: {品类id} {分页属性}
        'jiesongjiInfo'=>'http://jiesongji?.baicheng.com/?.html', //接送机终端页 参数: {SKU码}
        'jiesongjiTraveller'=>'http://jiesongji?.baicheng.com/traveller/?-?', //接送机订单完善客人信息页 参数: {主单ID}{产品ID}
        'jiesongjiTravellerSuccess'=>'http://jiesongji?.baicheng.com/traveller-success/?-?', //jiesongji订单完善客人信息成功页 参数: {主单ID}{产品ID}
        'jiesongjiOrderDetail'=>'http://jiesongji?.baicheng.com/single/order/detail/?/?', //jiesongji订单详情页 参数: {主单ID}{产品ID}

        //wifi
        'wifiIndex'=>'http://wifi?.baicheng.com', //wifi首页
        'wifiList'=>'http://wifi?.baicheng.com/?/?', //wifi筛选列表 参数：{品类id} {分页属性}
        'wifiInfo'=>'http://wifi?.baicheng.com/?.html', //wifi终端页 参数: {SKU码}

        //购物
        'shoppingIndex'=>'http://shopping?.baicheng.com', //购物首页
        'shoppingInfo'=>'http://shopping?.baicheng.com/?.html', //购物终端页 参数: {SKU码}

        //个人中心
        'passportHost'=>'http://passport?.baicheng.com', //host
        'userLogin'=>'http://passport?.baicheng.com/userlogin', //登录
        'userLoginWithCode'=>'http://passport?.baicheng.com/userlogin/orderlogin', //手机+短信验证码登录
        'userLoginJS'=>'http://passport?.baicheng.com/usercommon/loginboxjs/0?type=1', //登录弹层必须引用的JS文件URL(不含注册)
        'userReg'=>'http://passport?.baicheng.com/userreg', //注册
        'userInfo'=>'http://passport?.baicheng.com/member/showprofile', //基本信息
        'userAvatar'=>'http://passport?.baicheng.com/member/avatar', //设置头像
        'userEditpwd'=>'http://passport?.baicheng.com/member/editpwd', //修改密码
        'userPassenger'=>'http://passport?.baicheng.com/passenger/show', //常用旅客
        'userOrder'=>'http://passport?.baicheng.com/order/list', //我的订单
        'userComment'=>'http://passport?.baicheng.com/usercomment/commentlist', //我的评价
        'userConsult'=>'http://passport?.baicheng.com/userconsult/consultlist', //我的咨询
        'userCoupon'=>'http://passport?.baicheng.com/usercommon/mycoupon', //我的优惠券

        'activeCoupon'=>'http://passport?.baicheng.com/usercommon/activecoupon', //激活优惠券

        //底部导航
        'map'=>'http://visa?.baicheng.com/country/list', //网站地图
        'feedback'=>'http://www?.baicheng.com/index/feedback', //意见反馈
        'couponList'=>'http://dujia.baicheng.com/MemberCenter/CouponList_NoLogin.aspx', //百程优惠券
        'about'=>'http://www?.baicheng.com/index/about', //关于百程
        'contact'=>'http://www?.baicheng.com/index/contact', //联系我们
        'joinus'=>'http://www?.baicheng.com/index/joinus', //加入我们
        'cooperation'=>'http://www?.baicheng.com/index/cooperation', //合作伙伴
        'service'=>'http://www?.baicheng.com/index/service', //售后服务
        'history'=>'http://www?.baicheng.com/index/history', //百程大事件

        //后端webservice接口地址
        'WS_Web'=>'http://service?.baicheng.com/web.asmx?wsdl', //订单相关
        'WS_Group' => 'http://service?.baicheng.com/group.asmx?wsdl',
        'WS_Visa'=>'http://service?.baicheng.com/Visa.asmx?wsdl', //签证
        'WS_BuleCard'=>'http://service?.baicheng.com/Activity.asmx?wsdl', //蓝联卡
        'WS_WebSingle'=>'http://service?.baicheng.com/WebSingle.asmx?wsdl', //单项
        'WS_Free'=>'http://service?.baicheng.com/Free.asmx?wsdl', //特卖
        'WS_SendSMS'=>'http://service?.baicheng.com/ShortMsgService.asmx?wsdl', //短信
        'WS_Supp'=>'http://service?.baicheng.com/supp.asmx?wsdl', //供应商

        //会员接口
        'Api_Passport'=>'http://passport.internal?.baicheng.com/?', //参数: 具体的方法名
        'WS_Api_brs' => 'http://brs?.baicheng.com/index.php?',

        //旅行定制
        'customizedInfo'=>'http://www?.baicheng.com/customized/us/?.html', //旅行定制详情页

    );

    //填充输出url模板
    private static function tpl($h,$urlTpl,$params=array())
    {
        empty($h) && $h = 'dev';
        if($h!='online'){
            $h = ".{$h}";
        }else{
            $h ='';
        }
        !is_array($params) && $params = array();
        array_unshift($params,$h);

        foreach($params as $p){
            $urlTpl = preg_replace('/\?/',"$p",$urlTpl,1);
        }
        $env = \Illuminate\Support\Facades\Config::getEnvironment();
        if(in_array($env,self::$env_list)){
            $urlTpl = self::transferURL($urlTpl);
        }
        return $urlTpl;
    }

    public static function transferURL($url){
        $h = trim(\Illuminate\Support\Facades\Config::getEnvironment());
        $domain = $h!='online'?'http://www.'.$h.'.baicheng.com/':'http://www.baicheng.com/';
        if(empty($url)){
            return '';
        }
        $url_array = parse_url($url);
        $domain_array = explode('.',$url_array['host']);
        $sub_domain = current($domain_array);
        if(in_array($sub_domain,self::$sub_domain_list)){
            $new_url = $domain . $sub_domain.$url_array['path'];
            if(in_array($sub_domain,['jiesongji','yiriyou','tickets','shopping'])&&mb_eregi('^[0-9]+.*',$url_array['path'])){
                $new_url = $domain.$sub_domain.'/product'.$url_array['path'];
            }
            if($url_array['query']||$url_array['fragment']){
                $new_url = $new_url.'?'.$url_array['query'].$url_array['fragment'];
            }
            return $new_url;
        }else{
            return $url;
        }
    }

    public static function getSubDomain($url){
        //$domain = 'http://www.baicheng.com/';
        if(empty($url)){
            return '';
        }
        $url_array = parse_url($url);
        $domain_array = explode('.',$url_array['host']);
        $sub_domain = current($domain_array);
        return $sub_domain;
    }

    //重载各方法
    public function __call($name,$arguments)
    {
        return self::__callStatic($name,$arguments);
    }
    public static function __callStatic($name ,$arguments)
    {
        if(!isset(self::$urlTplArr[$name])){
            return NULL;
        }
        $h = trim(\Illuminate\Support\Facades\Config::getEnvironment());

        //后端接口地址没有dev , dev和test都是调用的test环境的后端接口
        if(preg_match('/WS_.+/',$name)){
            !in_array($h,array('preonline','online')) && $h = 'test';
            $arguments = array(); //无需传入参数, 如果传了也需清空
        }

        return self::tpl($h,self::$urlTplArr[$name],$arguments);
    }

    //region URL生成规则

    //region public
    /**
     * 依据产品类型和产品ID生成产品URL
     *
     * @param $type 产品类型
     * @param $productid 产品ID
     *
     * @return null
     */
    public static function GenProdDetail($type,$productid)
    {
        $Url = null;
        switch($type)
        {
            case '签证':
            case '1':
                $Url = \BC\Tools\URLHelper::visaInfo($productid);
                break;
            case '交通服务':
            case '56':
                $Url = \BC\Tools\URLHelper::jiesongjiInfo($productid);
                break;
            case '旅游装备':
                $Url = \BC\Tools\URLHelper::wifiInfo($productid);
                break;
            case '景点门票':
            case '29':
                $Url = \BC\Tools\URLHelper::ticketsInfo($productid);
                break;
            case '一日/半日游':
            case '50':
                $Url = \BC\Tools\URLHelper::yiriyouInfo($productid);
                break;
            case '游轮游船':
            case '当地游览':
                $Url = \BC\Tools\URLHelper::yiriyouInfo($productid);
                break;
            case '旅游书籍':
            case '演出表演':
            case '导游服务':
            case '特色餐饮':
            case '体育赛事':
            case '旅游装备':
            case '医疗美容':
                $Url = \BC\Tools\URLHelper::ticketsInfo($productid);
                break;
            case '特惠购物':
            case '70':
            case '71':
            case '72':
            case '73':
            case '74':
                $Url = \BC\Tools\URLHelper::shoppingInfo($productid);
                break;
            case '境外通讯':
                $Url = \BC\Tools\URLHelper::wifiInfo($productid);
                break;
            case '机场接送':
                $Url = \BC\Tools\URLHelper::jiesongjiInfo($productid);
                break;
            case '国际租车':
                $Url = \BC\Tools\URLHelper::izucheInfo($productid);
                break;
            case '跟团游':
            case '2':
                $Url = \BC\Tools\URLHelper::groupInfo($productid);
                break;
            case '自由行':
            case '3':
                $Url = \BC\Tools\URLHelper::packageInfo($productid);
                break;
        }
        return $Url;
    }

    //endregion

    //region 单项

    /**
     *生生订单详情页URL
     *
     * @param $SubOrderType 可以是类型ID，也可以是类型名字，还可以是子域名
     * @param $ProductID
     * @param $TradeOrderID
     *
     * @return null
     */
    public static function  Single_GenOrderDetailURl($SubOrderType,$ProductID,$TradeOrderID)
    {
        $Url = null;

        switch($SubOrderType)
        {
            case '机场接送':
            case '交通服务':
            case 'jiesongji':
                $Url = \BC\Tools\URLHelper::jiesongjiOrderDetail($TradeOrderID,$ProductID);
                break;
            case '旅游书籍':
            case '演出表演':
            case '导游服务':
            case '特色餐饮':
            case '体育赛事':
            case '旅游装备':
            case '医疗美容':
            case '景点门票':
            case 'tickets':
                $Url = \BC\Tools\URLHelper::ticketsOrderDetail($TradeOrderID,$ProductID);
                break;
            case '游轮游船':
            case '当地游览':
            case '一日/半日游':
            case 'yiriyou':
                $Url= \BC\Tools\URLHelper::yiriyouOrderDetail($TradeOrderID,$ProductID);
                break;
        }
        return $Url;
    }

    /**
     * @param $OrderID
     * @param null $Host
     *
     * @return null|string
     */
    public static function  Single_GenPayURl($OrderID,$Host=null)
    {
        $Url = null;
        $Url = ($Host ? $Host : UsualConst::G_HOST  ) . 'single/order/onlinepay/' . $OrderID;
        return $Url;
    }

    /**
     *完善单项订单客人信息
     *
     * @param $SubOrderType 可以是类型ID，也可以是类型名字，还可以是子域名
     * @param $ProductID
     * @param $TradeOrderID
     *
     * @return null
     */
    public static function  Single_GenCompleteClientInfoURl($SubOrderType,$ProductID,$TradeOrderID)
    {
        $Url = null;

        switch($SubOrderType)
        {
            case '机场接送':
            case '交通服务':
            case '接送机':
            case 'jiesongji':
                $Url = \BC\Tools\URLHelper::jiesongjiTraveller($TradeOrderID,$ProductID);
                break;
            case '旅游书籍':
            case '演出表演':
            case '导游服务':
            case '特色餐饮':
            case '体育赛事':
            case '旅游装备':
            case '医疗美容':
            case '景点门票':
            case '门票':
            case 'tickets':
                $Url = \BC\Tools\URLHelper::ticketsTraveller($TradeOrderID,$ProductID);
                break;
            case '游轮游船':
            case '当地游览':
            case '一日/半日游':
            case '日游':
            case 'yiriyou':
                $Url = \BC\Tools\URLHelper::yiriyouTraveller($TradeOrderID,$ProductID);
                break;
            default:
                $Url= \BC\Tools\URLHelper::singleClientinfo($TradeOrderID);
                break;
        }
        return $Url;
    }

    /**
     * @param $OrderID
     * @param null $Host
     *
     * @return null|string
     */
    public static function  Single_GenCancelorder($OrderID,$Host=null)
    {
        $Url = null;
        $Url = ($Host ? $Host : UsualConst::G_HOST  )  . 'single/order/cancelorder/' . $OrderID;
        return $Url;
    }
    //endregion

    //region 签证

    /**
     *签证频道：：生成签证产品详情页的URL njz20141209
     *
     * @param $visahost 签证主机头 如：visa.baicheng.com
     * @param $productid 签证产品ID
     * @return null|string  签证产品详情的URL地址
     */
    public static function Visa_GenVisaDetail( $visahost=null,$productid)
    {
        $Url = null;
        $Url = ($visahost ? $visahost : UsualConst::VISA_HOST  ) . 'product_' . $productid . '.html';
        return $Url;
    }

    /**
     *签证频道：：生成签证国家详情页的URL njz20141209
     *
     * @param $visahost 签证主机头 如：http://visa.baicheng.com
     * @param $countrypy 标准国家拼音
     * @param $countrycode 标准国家code
     * @return null|string  生成签证国家详情页的URL
     */
    public static function Visa_GenCountryDetail($visahost=null,$countrypy,$countrycode)
    {
        $Url = null;
        $Url = ($visahost ? $visahost : UsualConst::VISA_HOST) . 'country_'.$countrypy.'_'.$countrycode.'.html';
        return $Url;
    }
    //endregion


    //endregion
}
