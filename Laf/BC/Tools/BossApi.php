<?php
namespace BC\Tools;
use Illuminate\Support\Facades\Config;
class BossApi {

    #region 走webservice 的接口请求
    /**
     * @param $method
     * @param $params
     * @return array
     * @throws \Exception
     */
    public static function __callStatic($method, $params) {
        $serviceHost = self::getServiceHost($method);
		if(in_array($method, array('GetData_VisaIndex','GetData_Index','GetData_DayTourList', 'GetData_DayTourSearch', 'GetData_TicketIndex', 'GetData_JSJList', 'GetData_JSJSearch','GetData_TicketList','GetData_TicketSearch'))){
            return WebService::callMethod($serviceHost, $method, $params[0], 30, 3600);
		}
        return WebService::callMethod($serviceHost, $method, $params[0]);
    }

    /**
     *
     * 根据调用方法名称获取对应的host
     * @param $method  调用方法名
     * @return mixed
     * @throws \Exception
     */
    public static function getServiceHost($method) {

        $urlAliasKey  = '';
        foreach (self::$methodToHost as $key => $methods) {
            if (in_array($method, $methods)) {
                $urlAliasKey = $key;
                break;
            }
        }

        if (empty($urlAliasKey)) {
            throw new \Exception('没有定义BossApi 中没有定义此方法', 1000001);
        }

        return URLHelper::$urlAliasKey();
    }
    private static $methodToHost = array(
        // 订单相关接口 http://service?.baicheng.com/web.asmx?wsdl
        'WS_Web' => array(
            'GetOrderInfoList',
            'GetData_Index',
            'GetData_VisaIndex',
            'getcountrylist',//wiki地址：http://192.168.3.172/baichengfe/doc/wikis/visa-channel#toc_15
            'getprovincelist',//wiki地址：http://192.168.3.172/baichengfe/doc/wikis/visa-channel#toc_16
            'getcountnocancel',//wiki地址：http://192.168.3.172/baichengfe/doc/wikis/visa-channel#toc_17
            'PreHall_GetOtherOrders',//wiki地址：http://192.168.3.172/baichengfe/doc/wikis/visa-channel#toc_17
            'GetTradeDetailNewWeb',//wiki地址：http://wiki.baicheng.com/index.php/%E5%AF%B9%E5%A4%96API#.E8.8E.B7.E5.8F.96.E4.BA.A4.E6.98.93.E8.AF.A6.E7.BB.86.E4.BF.A1.E6.81.AF_GetTradeDetail
            'FinishPay',//wiki地址：


        ),
        // 签证相关接口 http://service?.baicheng.com/Visa.asmx?wsdl
        'WS_Visa' => array(

        ),
        // 单项相关接口 http://service?.baicheng.com/WebSingle.asmx?wsdl
        'WS_WebSingle' => array(
            //以下接口文档地址：http://192.168.3.172/baichengfe/doc/wikis/IndexList2015
            'GetData_TicketIndex',
            'GetData_TicketList',
            'GetData_TicketSearch',
            'GetData_JSJList',
            'GetData_JSJSearch',
            'GetData_DayTourList',
            'GetData_DayTourSearch',
            'GetData_WIFIList',
            'GetData_WIFISearch',
            //以下接口文档地址：http://192.168.3.172/baichengfe/doc/wikis/singles
            'GetDistinationList',//获取目的地列表
            'GetProductTypeList',//获取国际单项商品类型列表
            'GetProductList',//获取国际单项商品列表
            'GetProductInfo',//获取国际单项商品详情
            'GetProductUnitInfo',//获取指定商品的最小单元详情
            'GetRecommandProductList',//获取国际单项推荐商品
            'CreateTrade',//国际单项下单
            'CreateTraveller',//添加旅游者信息即完善客人信息
            'GetTradeList',//获取国际单项订单列表
            'CancelTrade',//单项订单取消
            'FinishPay',//完成支付 支付成功后扣除库存。
            'CreateTraveller',//国际单项获取订单详情
            'GetTradeInfo',//国际单项获取订单详情
            'getTicketConfirmation',//国际单项门票确认单
            'updateTradeInfo',//国际单项WIFI完善联系人信息
            'GetConfirmInfo',//国际单项门票获取确认单信息
            'CreateConfirmPdf',//国际单项门票下载通知
            'getCommonlyUsedContactList',//获取常用联系人
            'GetOrderDetailByOrderId',//单项获取订单详情
            'GetTradeInfoByProd',//按产品分组获取国际单项订单详情
            'getSingleConfirm',// 单项获取确认单（门票除外)
            'GetUsualClientList',//获取常用联系人
        ),
        // 蓝联卡对应接口 http://service?.baicheng.com/Activity.asmx?wsdl
        'WS_BuleCard' => array(

        ),
        //自由行相关接口  http://service?.baicheng.com/Free.asmx?wsdl
        'WS_Free' => array(
            'GetData_PackageIndex',
            'GetData_PackageList',
            'GetData_PackageSearch',
            'GetData_GroupIndex',
            'GetData_DepartCity'
        ),
        //跟团游相关接口 http://service?.baicheng.com/group.asmx?wsdl
        'WS_Group' => array(
            'GetData_GroupList',
            'GetData_GroupSearch',
        ),
        //供应商相关接口 http://service?.baicheng.com/supp.asmx?wsdl
        'WS_Supp' => array(
            'CreateSuppTraveller',
            'GetDayOrderInfoList',
            'GetSuppContact',
            'GetSuppOrderConfirm_Ticket',
            'GetSuppOrderDetail',
            'GetSuppOrderList',
            'GetSuppTicketOrderList',
            'OperaPickupOrder',
            'TicketOption',
            'UpdatePwd',
            'UpdateSuppContact',
            'UserLogin'
        ),
        //短信相关接口 http://service?.baicheng.com/ShortMsgService.asmx?wsdl
        'WS_SendSMS' => array(

        ),

        //会员中心相关接口 http://service?.baicheng.com/ShortMsgService.asmx?wsdl
        'Api_Passport' => array(

        ),

        //会员中心相关接口 http://brs?.baicheng.com/index.php
        'WS_Api_brs' => array(

        ),

    );
    #endregion


    /**
     * 删除价格后的0 njz20151015
     *
     * @param $s
     * @return mixed|string
     */
    public static function del0($s)
    {
        $s = trim(strval($s));
        if (preg_match('#^-?\d+?\.0+$#', $s)) {
            return preg_replace('#^(-?\d+?)\.0+$#','$1',$s);
        }
        if (preg_match('#^-?\d+?\.[0-9]+?0+$#', $s)) {
            return preg_replace('#^(-?\d+\.[0-9]+?)0+$#','$1',$s);
        }
        return $s;
    }

    #region 走http请求的接口

    /**
     * 获取签证频道有效签证国家列表 njz20150918
     *
     * @return mixed
     */
    public static function Http_GetVisaCountryList2(){
        $data['hot'] = '';
        $data['platform'] = 'pc';
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','country',$data,'getCountryList',0,600);
        return array_get($HttpReturn,'data');
    }
    /**
     * 获取签证频道有效签证国家列表 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_14
     *
     *
     * @param $ChanelID 来源渠道 扩展用
     * @param $FromID 来源方式 扩展用
     * @return mixed
     */
    public static function Http_GetVisaCountryList($ChanelID,$FromID){
        $data['data']['chanelid'] = $ChanelID;
        $data['data']['fromid'] = $FromID;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getCountryList',0,600);
        return array_get($HttpReturn,'data');
    }

    /**
     * 获取推荐商品列表 njz20150917
     *
     * @param $countrycode
     * @return mixed
     */
    public static function PreHall_GetRecommendProd($countrycode){
        $data['data']['account_id'] = '';// 用户ID
        $data['data']['sub_order_id'] = '';// 子订单ID
        $data['data']['countrycode'] = $countrycode;// 国家
        $data['data']['apply'] = 4;// 4：代表PC
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('boss','php',$data,'Hall_GetRecommendByCountry');
        return array_get($HttpReturn,'data');
    }

    /**
     * 售前厅获取当前登录会员的其它签证列表(含未支付) njz20150820
     * @param $uid 当前登录会员ID
     * @param $subOrderID 子订单ID
     * @return mixed
     */
    public static function PreHall_GetSubVisaOrders($uid,$subOrderID){
        $data['data']['account_id'] = $uid;// 用户ID
        $data['data']['sub_order_id'] = $subOrderID;// 子订单ID
        $order_list = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'PreHall_GetSubVisaOrders');
        return array_get($order_list,'data');
    }

    /**
     * 售前厅获取当前登录会员的其它签证列表(含未支付) njz20150820
     *
     * @param $uid
     * @return mixed
     */
    public static function GetUserVisaOrderExtend($uid){
        $data['data']['account_id'] = $uid;
        $order_list = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'GetUserVisaOrderInfoExtend');
        return array_get($order_list,'data');
    }

    /**
     * 根据国家CODE获取当前国家领事馆时间最近的两个工作日  njz20150820
     *
     * @param $CountryCode
     * @return mixed
     */
    public static function GetEffectiveWorkingDaysByCode($CountryCode){
        $data['data']['countryCode'] = $CountryCode;
        $order_list = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'GetEffectiveWorkingDaysByCode');
        return array_get($order_list,'data');
    }


    /**
     * 获取指定国家的产品和办签信息   njz20150820
     *
     * @param $CountryCode
     * @param $CountryPY
     * @param $ProvinceID
     * @param $VisaType
     * @return mixed
     */
    public static function GetVisaCountryInfo($CountryCode,$CountryPY,$ProvinceID,$VisaType){
        $data['data']['countrycode'] = $CountryCode;
        $data['data']['countrypy'] = $CountryPY;
        $data['data']['provinceid'] = $ProvinceID;
        $data['data']['visatype'] = $VisaType;
        $order_list = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'GetVisaCountryInfo');
        return array_get($order_list,'data');
    }

    /**
     * 获取签证国家相关信息 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_4
     *
     *
     * @param $CountryCode 必填 国家的二字码
     * @param $CountryPY 选填 国家的拼音
     * @param $ProvinceID 必填 省份id 若为0，则不参与过滤条件
     * @param $VisaType 必填 签证类型 若为0，则不参与过滤条件
     * @return mixed
     */
    public static function Http_GetVisaList($CountryCode,$CountryPY,$ProvinceID,$VisaType){
        $data['data']['countrycode'] = $CountryCode;
        $data['data']['countrypy'] = $CountryPY;
        $data['data']['provinceid'] = $ProvinceID;
        $data['data']['visatype'] = $VisaType;
        return self::Http_GetVisaList2($data);

    }

    /**
     * @param $params
     * @return mixed|null|string
     */
    public static function Http_GetVisaList2($params)
    {
        $Cache_key = 'Http_GetVisaList_'.md5(json_encode($params));
        $response = \BC\Tools\BCCache::get($Cache_key);
        if(empty($response))
        {
            $response = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$params,'GetVisaCountryInfo');
            //echo json_encode($response);die();
            if($response['code']!='100000')
            {
                return '获取数据失败!code:getvisalist_bycountrycode    returnmsg:'.$response['message'].' returncode:'.$response['code'];
            }
            else
            {
                $response = array_get($response,'data');

                \BC\Tools\BCCache::set($Cache_key,$response,60);\BC\Tools\BCCache::AllCacheKey($Cache_key);
            }

        }
        return $response;
    }


    /**
     * 获取签证国家注意事项 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_5
     *
     *
     * @param $CountryCode 必填 国家的二字码
     * @return mixed
     */
    public static function Http_GetVisaCountryInfo($CountryCode){
        if(!$CountryCode) return [];
        $data['country_code'] = $CountryCode;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','country',$data,'getCountryExtend');
        return array_get($HttpReturn,'data');
    }
   
    /**
     * 获取签证产品信息 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_6
     *
     *
     * @param $ProdID 必填且大于0 签证产品id
     * @return mixed
     */
     /**
     * 获取签证产品信息 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_6
     *
     *
     * @param $ProdID 必填且大于0 签证产品id
     * @return mixed
     */
    public static function Http_GetVisaInfo($ProdID, $chn=''){
        $data['data']['prodid'] = $ProdID;
        if($chn){
            $data['data']['chn'] = $chn;
        }
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getvisainfo');
        $data = array_get($HttpReturn,'data');
        if($data['steps']){
            foreach ($data['steps'] as $stepskey=>$stepsvalue){
                $data['steps'][$stepskey]['stepcontent'] = htmlspecialchars_decode($stepsvalue['stepcontent']);
            }
        }
        return $data;
    }
    /**
     * 分页获取签证产品评论 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_7
     *
     *
     * @param $ProdID 必填且大于0 签证产品id
     * @param $PageSize 必填且大0 每页显示的条数
     * @param $PageIndex 必填且大于0 当前页索引
     * @return mixed
     */
    public static function Http_GetVisaComment($ProdID,$PageSize,$PageIndex){
        $data['data']['prodid'] = $ProdID;
        $data['data']['pagesize'] = $PageSize;
        $data['data']['pageindex'] = $PageIndex;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getvisa_comment',0,60);
        return array_get($HttpReturn,'data');
    }
    /**
     * 分页获取签证产品咨询问答 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_8
     *
     *
     * @param $ProdID 必填且大于0 签证产品id
     * @param $PageSize 必填且大0 每页显示的条数
     * @param $PageIndex 必填且大于0 当前页索引
     * @return mixed
     */
    public static function Http_GetVisaQA($ProdID,$PageSize,$PageIndex){
        $data['data']['prodid'] = $ProdID;
        $data['data']['pagesize'] = $PageSize;
        $data['data']['pageindex'] = $PageIndex;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getvisa_qa',0,60);
        return array_get($HttpReturn,'data');
    }
    /**
     * 获取指定国家的领事馆信息 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_9
     *
     *
     * @param $CountryCode 必填 国家code 如US
     * @return mixed
     */
    public static function Http_GetConsularInfo($CountryCode){
        $data['data']['countrycode'] = $CountryCode;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getconsularinfo',0,600);
        return array_get($HttpReturn,'data');
    }

    /**
     * 获取指定国家的公告信息 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_10
     *
     *
     * @param $CountryName 必填 国家名
     * @return mixed
     */
    public static function Http_GetAnnouncementInfo($CountryName){
//        $data['data']['countryName'] = $CountryName;
//        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('cms','visa_notice',$data,'getannouncementinfo',0,600);
//        return array_get($HttpReturn,'data');

        $HttpReturn = \BC\Tools\IOTool::request('cms', 'visa_notice', [
            'countryName' => $CountryName,
        ], 0, 600);
        return $HttpReturn;
    }
    /**
     * 提交针对特定产品的问答咨询 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_11
     *
     *
     * @param $ProdID 必填 产品id
     * @param $Q 必填用户咨询内容
     * @param $UserID 必填 若有登录，则返回当前登录会员id；否则返回-1
     * @param $UserName 必填 若有登录，则返回当前登录会员昵称；否则返回空字符串
     * @return mixed
     */
    public static function Http_PostQA($ProdID,$Q,$UserID,$UserName){
        $data['data']['prodid'] = $ProdID;
        $data['data']['q'] = $Q;
        $data['data']['userid'] = $UserID;
        $data['data']['username'] = $UserName;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'postqa');
        return array_get($HttpReturn,'data');
    }


    /**
     * 获取签证国家可受理省份列表 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_12
     *
     *
     * @param $CountryCode 必填 国家code 如US
     * @return mixed
     */
    public static function Http_GetVisaProvinces($CountryCode){
        $data['data']['countrycode'] = $CountryCode;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'GetVisaProvinces',0,600);
        return array_get($HttpReturn,'data');
    }

    /**
     * 获取签证套餐相关信息 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_13
     *
     *
     * @param $ProdID 必填 产品id
     * @return mixed
     */
    public static function Http_GetVisaPackageInfo($ProdID){
        $data['data']['prodid'] = $ProdID;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getpackageinfo',0,600);
        return array_get($HttpReturn,'data');
    }


    /**
     * 通过逗号分隔的交易订单ID串返回非“已取消”订单的数量 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_15
     *
     *
     * @param $TradeOrders 逗号分隔的交易订单ID串
     * @return mixed
     */
    public static function Http_GetVisaOrderCount($TradeOrders){
        $data['data']['tradeorders'] = $TradeOrders;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getCountNoCancel');
        return array_get($HttpReturn,'data');
    }

    /**
     * 帮助中心-获取当前国家常见问题 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_16
     *
     *
     * @param $CountryCode 国家code
     * @return mixed
     */
    public static function Http_GetVisaQuestion($CountryCode){
        $data['data']['countryCode'] = $CountryCode;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getquestion_bycountrycode',0,600);
        return array_get($HttpReturn,'data');
    }
    /**
     * 帮助中心-获取所有的常见问题 njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_17
     *
     *
     * @return mixed
     */
    public static function Http_GetVisaAllQuestion(){
        return self::Http_GetVisaQuestion('');
    }
    /**
     * 帮助中心-获取常见问题根据分类  njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_18
     *
     * @param $CategoryID 分类id
     *
     * @return mixed
     */
    public static function Http_GetVisaQuestionByCategory($CategoryID){
        $data['data']['category_id'] = $CategoryID;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getquestion_bycategory',0,600);
        return array_get($HttpReturn,'data');
    }
    /**
     * 帮助中心-获取当前国家的所有可办签证类型   njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_19
     *
     * @param $CountryCode 国家二字码
     *
     * @return mixed
     */
    public static function Http_GetVisaType($CountryCode){
        $data['data']['countrycode'] = $CountryCode;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getvisatype_bycountrycode',0,600);
        $VisaTypeList = array_get($HttpReturn,'data');
        if(!empty($VisaTypeList))
        {
            foreach($VisaTypeList['typelist'] as $k=>$v)
            {
                if($v['type']=='18'||$v['type']=='67')//探亲签证和访友签证合并成“探亲访友签证”
                {
                    $VisaTypeList['typelist'][$k]['typename'] = '探亲访友签证';
                }
                if($v['type']=='19')//其它签证 直接去掉
                {
                    array_splice($VisaTypeList['typelist'],$k,1);
                }

            }
        }
        return $VisaTypeList;
    }
    /**
     * 签证下单   njz20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_20
     *
     * @param $OrderData 创建签证订单要提交的信息集合
     *
     * @return mixed
     */
    public static function Http_CreateVisaOrder($OrderData){
        $data['data'] = $OrderData;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'createorderwithvisa');
        return array_get($HttpReturn,'data');
    }
     /**
     * 获取签证国家保险 ljs20150910
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_21
     *
     *
     * @param $CountryCode 必填 国家的二字码
     * @return mixed
     */
    public static function Http_GetVisaInsuranceInfo($CountryCode){
        //接口名InsuranceInfo换成GetInsurancesByCountryExpend
        $data['data']['country_code'] = $CountryCode;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'GetInsurancesByCountryExpend',0,600);
        return array_get($HttpReturn,'data');
    }
    
    /**
     * 分页获取使馆公告 
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_22
     *
     *
     * @param $countrycode 必填且大于0 国家code
     * @param $PageSize 必填且大0 每页显示的条数
     * @param $PageIndex 必填且大于0 当前页索引
     * @return mixed
     */
    public static function Http_GetCountryNoticeList($CountryCode,$PageSize,$PageIndex){
        $data['data']['countrycode'] = $CountryCode;
        $data['data']['pagesize'] = $PageSize;
        $data['data']['pageindex'] = $PageIndex;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app_php_notice',$data,'getnoticelist',0,60);
        //print_r(json_encode($HttpReturn));die();
        return array_get($HttpReturn,'data');
    }

    /**
     * 获取特定使馆公告
     *接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_24
     *
     * @param $id 使馆公告ID
     * @return mixed
     */
    public static function Http_GetCountryNoticeDetail($id){
        $data['data']['id'] = $id;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app_php_notice',$data,'getnoticedetail',0,60);
        //print_r(json_encode($HttpReturn));die();
        return array_get($HttpReturn,'data');
    }
      /**
     * 分页获取国家常见问题   njz20151015
     *
     * 接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_23
     *
     *
     * @param $countrycode 必填且大于0 国家code
     * @param $PageSize 必填且大0 每页显示的条数
     * @param $PageIndex 必填且大于0 当前页索引
     * @return mixed
     */
    public static function Http_GetCountryQuestionList($countrycode,$PageSize,$PageIndex){
        $data['data']['countrycode'] = $countrycode;
        $data['data']['pagesize'] = $PageSize;
        $data['data']['pageindex'] = $PageIndex;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app_php',$data,'getquestionlist',0,60);
        return array_get($HttpReturn,'data');
    }
    /**
     * 获取特定常见问题  njz20151015
     *接口定义地址：http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_25
     *
     * @param $id 常见问题ID
     * @return mixed
     */
    public static function Http_GetCountryQuestionDetail($id){
        $data['data']['id'] = $id;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app_php',$data,'getquestiondetail',0,60);
        //print_r(json_encode($HttpReturn));die();
        return array_get($HttpReturn,'data');
    }

    /**
     * 获取单个广告详情信息 njz20151015
     * http://192.168.3.172/baichengfe/doc/wikis/visa_price_new#toc_26
     *
     * @param $id
     * @return mixed
     */
    public static function Http_GetAdDetail($siteid,$pageid,$locationid){
        $data['data']['siteid'] = $siteid;
        $data['data']['pageid'] = $pageid;
        $data['data']['locationid'] = $locationid;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getaddetail',0,60);
        //print_r(json_encode($HttpReturn));die();
        return array_get($HttpReturn,'data');
    }
    /**
     * 获取获取所有活动列表 ljs20151027
     * http://192.168.3.172/baichengfe/doc/wikis/visa_wanshida#toc_4
     *
     * @param $activitytype 
     * @return mixed
     */
    public static function Http_GetActivityList($activitytype=''){
        $data['data']['activitytype'] = $activitytype;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getActivityList',0,60);
        //print_r(json_encode($HttpReturn));die();
        return array_get($HttpReturn,'data');
    }
        /**
     * 获取指定商品所属活动信息 ljs20151027
     * http://192.168.3.172/baichengfe/doc/wikis/visa_wanshida#toc_5
     *
     * @param $goodid 
     * @param $activitytype 
     * @return mixed
     */
    public static function Http_GetActivityById($goodid,$activitytype=''){
        $data['data']['goodid'] = $goodid;
        $data['data']['activitytype'] = $activitytype;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getActivityById',0,60);
        //print_r(json_encode($HttpReturn));die();
        return array_get($HttpReturn,'data');
    }
    /**
     * 根据手机号获取用户ID（不存在则预注册） ljs20151106
     *
     * @param $goodid 
     * @param $activitytype 
     * @return mixed
     */
    public static function Http_GetUidByIphone($iphone){
        $data['trace_id'] = '21323';
        $data['data']['cond']['username'] = $iphone;
        $data['data']['cond']['presignup_from'] = 1;
        $HttpReturn = \BC\Tools\IOTool::httpRequest(Config::get("api.http.PC_H5_App.app_php_account"),'post',array('params'=>  json_encode($data)));
        //print_r(json_encode($HttpReturn));die();
        $HttpReturn = json_decode($HttpReturn,true);
        if($HttpReturn['code']==100000)
            return $HttpReturn['data'];
        else
            return false;

    }

    #endregion
    /**
     * 根据商品id查询商品是否参加活动
     *
     * @param $goods_id(子单Id)
     * @return mixed
     */
    public static function Http_GetActivityByItemId($goods_id){
        $req['data'] = array(
            'item_id'=>$goods_id
        );

        $ret = \BC\Tools\IOTool::HttpRequestWithParams('interface','lobby', $req ,'GetActivityByItemId');
        //print_r($ret) ;die;
        return $ret['data'];
    }  
     #endregion
    /**
     * 获取平安保险列表 ljs20151207
     *
     * @return mixed
     */
    public static function Http_GetPingAnList(){
        $data['data']['Request'] = '';
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app_php',$data,'pingAN_GetList',0,600);
        return array_get($HttpReturn,'data');
    }
    /**
     * 获取出签信息 ljs20160308
     * @param $orderId 子单ID
     * @return mixed
     */
    public static function getVisaOrderResultData($orderId){
        $data['data']['orderId'] = $orderId;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app_php',$data,'getVisaOrderResultData',0,600);
        return array_get($HttpReturn,'Response');
    }
    
    /**
     * 退款申请
     * @param $params
     * @return mixed
     */
    public static function orderRefundSubmit($params){
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$params,'submitOrderRefund');
        return $HttpReturn;
    }
    /**
     * 退款查询
     * @param $params
     * @return mixed
     */
    public static function orderRefundCheck($params){
    	$HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$params,'getOrderRefundInfo');
    	return $HttpReturn;
    }
}
