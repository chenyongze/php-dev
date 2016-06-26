<?php
    /**
     * Created by PhpStorm.
     * User: njz
     * Date: 15-2-10
     * Time: 下午7:01
     *
     * 描述：外部提供的接口及服务；
     *
     */

    namespace BC\BLL;
    use BC\Tools;
    use Illuminate\Support\Facades;

    /**
     * 外部提供的接口及服务；
     * @package BC\BLL
     */
    class OuterServices
    {
        //region 字典数据
        public function GetData_DepartCity(array $params)
        {
            $response = \BC\Tools\BossApi::GetData_DepartCity($params);
            if ($response['code'] != 'SUCCESS') {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_DepartCity');
            } else {
                $response = $response['data']['depart_citys'];
            }
            return $response;
        }
        //endregion


        //region www

        public static function GetData_Index(array $params)
        {
            $Cache_key = 'GetData_Index_'.md5(json_encode($params));
            $response = \BC\Tools\BCCache::get($Cache_key);
            if(empty($response))
            {
                $response = \BC\Tools\BossApi::GetData_Index($params);
                if($response['code']!='SUCCESS')
                {
                    \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_Index');
                }
                else
                {
                    $response = $response['data'];

                    \BC\Tools\BCCache::set($Cache_key,$response,3600);\BC\Tools\BCCache::AllCacheKey($Cache_key);
                }

            }
            return $response;
        }
        //endregion

        //region 自由行
        public function GetData_PackageIndex(array $params)
        {
            $Cache_key = 'GetData_PackageIndex'.md5(json_encode($params));
            $response = \BC\Tools\BCCache::get($Cache_key);
            if(empty($response))
            {
                $response = \BC\Tools\BossApi::GetData_PackageIndex($params);
                if($response['code']!='SUCCESS')
                {
                    \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_PackageIndex');
                }
                else
                {
                    $response = $response['data'];
                    \BC\Tools\BCCache::set($Cache_key,$response,3600);\BC\Tools\BCCache::AllCacheKey($Cache_key);
                }
            }
            return $response;
        }

        public function GetData_PackageList(array $params)
        {
            $Cache_key = 'GetData_PackageList'.md5(json_encode($params));
            $response = \BC\Tools\BCCache::get($Cache_key);
            if(empty($response))
            {
                $response = \BC\Tools\BossApi::GetData_PackageList($params);
                if($response['code']!='SUCCESS')
                {
                    \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_PackageList');
                }
                else
                {
                    $response = $response['data'];
                    \BC\Tools\BCCache::set($Cache_key,$response,3600);\BC\Tools\BCCache::AllCacheKey($Cache_key);
                }
            }
            return $response;
        }

        public function GetData_PackageSearch(array $params)
        {
            $response = \BC\Tools\BossApi::GetData_PackageSearch($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_PackageSearch');
            }
            else
            {
                $response = $response['data']['search_results'];
            }
            return $response;
        }
        //endregion

        //region 跟团游
        public static function GetData_GroupIndex(array $params)
        {
            $Cache_key = 'GetData_GroupIndex'.md5(json_encode($params));
            $response = \BC\Tools\BCCache::get($Cache_key);
            if(empty($response))
            {
                $response = \BC\Tools\BossApi::GetData_GroupIndex($params);
                if($response['code']!='SUCCESS')
                {
                    \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_GroupIndex');
                }
                else
                {
                    $response = $response['data'];
                    \BC\Tools\BCCache::set($Cache_key,$response,3600);\BC\Tools\BCCache::AllCacheKey($Cache_key);
                }
            }
            return $response;
        }

        public static function GetData_GroupList(array $params)
        {
            $Cache_key = 'GetData_GroupList'.md5(json_encode($params));
            $response = \BC\Tools\BCCache::get($Cache_key);
            if(empty($response))
            {
                $response = \BC\Tools\BossApi::GetData_GroupList($params);
                if($response['code']!='SUCCESS')
                {
                    \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_GroupList');
                }
                else
                {
                    $response = $response['data'];
                    \BC\Tools\BCCache::set($Cache_key,$response,3600);\BC\Tools\BCCache::AllCacheKey($Cache_key);
                }
            }
            return $response;

        }

        public static function GetData_GroupSearch(array $params)
        {

            $response = \BC\Tools\BossApi::GetData_GroupSearch($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_GroupSearch');
            }
            else
            {
                $response = $response['data']['search_results'];
            }

            return $response;
        }
        //endregion

        //region visa


        public static function PreHall_GetSubVisaOrders($uid,$subOrderID){
//            $Cache_key = 'GetOrderListByUID'.md5(json_encode($uid));
//            $response = \BC\Tools\BCCache::get($Cache_key);
//
//            if(empty($response))
//            {
//                $response = null;
//                try
//                {
//                    $response = \BC\Tools\BossApi::getOrderListByUID($uid);
//                    \BC\Tools\BCCache::set($Cache_key,$response,600);\BC\Tools\BCCache::AllCacheKey($Cache_key);
//                }
//                catch ( Exception $e ) {
//                    var_dump ( $e -> getMessage ());
//                }
//            }
//            return $response;
            $response = null;
            try
            {
                $response = \BC\Tools\BossApi::PreHall_GetSubVisaOrders($uid,$subOrderID);
            }
            catch ( Exception $e ) {
                var_dump ( $e -> getMessage ());
            }
            return $response;
        }


        public static function GetUserVisaOrderExtend($uid){
            $response = null;
            try
            {
                $response = \BC\Tools\BossApi::GetUserVisaOrderExtend($uid);
            }
            catch ( Exception $e ) {
                var_dump ( $e -> getMessage ());
            }
            return $response;
        }
        /**
         * 获取所有可办理签证的国家列表 njz20150519
         *
         * @return mixed|null
         */
        public static function Visa_GetAllCountry()
        {
            $Cache_key = 'Visa_GetAllCountry';
            $response = \BC\Tools\BCCache::get($Cache_key);
            if(empty($response))
            {
                $response = \BC\Tools\BossApi::getcountrylist();//wiki地址：http://192.168.3.172/baichengfe/doc/wikis/visa-channel#toc_15

                if($response['code']!='SUCCESS')
                {
                    \BC\Tools\GlobalTool::checkException(false, '获取数据失败:getcountrylist');
                }
                else
                {
                    $response = $response['data'];
                    \BC\Tools\BCCache::set($Cache_key,$response,600);\BC\Tools\BCCache::AllCacheKey($Cache_key);
                }
            }
            return $response;
        }

        /**
         * 通过国家ID获取相应的办理省份列表 njz20150519
         *
         * @param $CountryID 国家ID
         * @return mixed|null
         */
        public static function Visa_GetProvinceList($CountryID)
        {
            $Cache_key = 'Visa_GetProvinceList'.md5(json_encode($CountryID));
            $response = \BC\Tools\BCCache::get($Cache_key);

            if(empty($response))
            {
                $response = \BC\Tools\BossApi::getprovincelist(['countryid'=>$CountryID]);
                if($response['code']!='SUCCESS')
                {
                    \BC\Tools\GlobalTool::checkException(false, '获取数据失败:getprovincelist');
                }
                else
                {
                    $response = $response['data'];
                    \BC\Tools\BCCache::set($Cache_key,$response,600);\BC\Tools\BCCache::AllCacheKey($Cache_key);
                }
            }
            return $response;
        }

        /**
         * 根据指定逗号分隔的订单ID串，获取非“已取消”订单的数量 njz20150519
         *
         * @param $tradeorders　逗号分隔的订单ID串
         * @return mixed|null
         */
        public static function Visa_GetCountNoCancel($tradeorders)
        {
            $response = \BC\Tools\BossApi::getcountnocancel(['tradeorders'=>$tradeorders]);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:Visa_GetCountNoCancel');
            }
            else
            {
                $response = $response['data']['count'];
            }
            return $response;
        }
        public static function GetData_VisaIndex(array $params)
        {
            $Cache_key = 'GetData_VisaIndex'.md5(json_encode($params));
            $response = \BC\Tools\BCCache::get($Cache_key);
            if(empty($response))
            {
                $response = \BC\Tools\BossApi::GetData_VisaIndex($params);
                if($response['code']!='SUCCESS')
                {
                    \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_VisaIndex');
                }
                else
                {
                    $response = $response['data'];
                    \BC\Tools\BCCache::set($Cache_key,$response,3600);\BC\Tools\BCCache::AllCacheKey($Cache_key);
                }
            }
            return $response;
        }
        //endregion

        //region 单项
        public static function GetData_TicketIndex(array $params)
        {
            $response = \BC\Tools\BossApi::GetData_TicketIndex($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_TicketIndex');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }

        public static function GetData_TicketList(array $params)
        {
            $response = \BC\Tools\BossApi::GetData_TicketList($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_TicketList');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }

        public static function GetData_TicketSearch(array $params)
        {
            $response = \BC\Tools\BossApi::GetData_TicketSearch($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_TicketSearch');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }

        public static function GetData_JSJList(array $params)
        {
            $response = \BC\Tools\BossApi::GetData_JSJList($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_JSJList');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }

        public static function GetData_JSJSearch(array $params)
        {
            $response = \BC\Tools\BossApi::GetData_JSJSearch($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_JSJSearch');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }

        public static function GetData_DayTourList(array $params)
        {
            $response = \BC\Tools\BossApi::GetData_DayTourList($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_DayTourList');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }

        public static function GetData_DayTourSearch(array $params)
        {
            $response = \BC\Tools\BossApi::GetData_DayTourSearch($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_DayTourSearch');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }

        public static function GetData_WIFIList(array $params)
        {
            $response = \BC\Tools\BossApi::GetData_WIFIList($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_WIFIList');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }

        public static function GetData_WIFISearch(array $params)
        {
            $response = \BC\Tools\BossApi::GetData_WIFISearch($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetData_WIFISearch');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }
        //endregion

        //region 订单相关

        public static function GetTradeInfoByProd($Trade_id,$OrderProductID)
        {
            $params['Trade_id'] = $Trade_id;
            $params['OrderProductID'] = $OrderProductID;
            $response = \BC\Tools\BossApi::GetTradeInfoByProd($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetTradeInfoByProd');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }
        /**
         * 通过主单ID 获取订单信息
         *
         * @param $trade_id
         *
         * @return mixed
         */
        public static function GetTradeInfo($trade_id)
        {
            $params['trade_id'] = $trade_id;
            $response = \BC\Tools\BossApi::GetTradeInfo($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetTradeInfo');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }


        /**
         * 添加旅游客人信息（即领用电子票）
         * @param int $trade_id 订单ＩＤ
         * @param array $travellers 　客人集合
         * @return mixed
         */
        public static function CreateTraveller($trade_id, $travellers)
        {
            $params['trade_id'] = $trade_id;
            $params['travellers'] = $travellers;
            $response = \BC\Tools\BossApi::CreateTraveller($params);

            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '提交数据失败:CreateTraveller');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }
        /**
         * 添加旅游客人信息（即领用电子票）
         * @param int $trade_id 订单ＩＤ
         * @param array $travellers 　客人集合
         * @return mixed
         */
        public static function CreateSuppTraveller($trade_id, $travellers)
        {
            $params['trade_id'] = $trade_id;
            $params['travellers'] = $travellers;
            $response = \BC\Tools\BossApi::CreateSuppTraveller($params);

            //print(json_encode($response) );die();
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '提交数据失败:CreateSuppTraveller');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }
        //endregion

        //region 产品相关
        /**
         * 通过主单ID 获取产品相关信息
         *
         * @param $product_id
         *
         * @return mixed
         */
        public static function GetProductInfo($product_id)
        {
            $params['product_id'] = $product_id;
            $response = \BC\Tools\BossApi::GetProductInfo($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetProductInfo');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }
        public static function GetRecommandProductList($destination_id)
        {
            $params['destination_id'] = $destination_id;
            $response = \BC\Tools\BossApi::GetRecommandProductList($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetRecommandProductList');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }
        //endregion

        //region 会员相关

        /**
         * 获取常用联系人
         *
         * @param $uid 会员 ID
         *
         * @return mixed
         */
        public static function getCommonlyUsedContactList($uid)
        {
            $params['uid'] = $uid;
            $response = \BC\Tools\BossApi::getCommonlyUsedContactList($params);
            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:getCommonlyUsedContactList');
            }
            else
            {
                $response = $response['data']['list'];
            }
            return $response;
        }
        /**
         * 通过会员ID获取常用客人列表
         *
         * @param $uid 会员 ID
         *
         * @return mixed
         */
        public static function GetUsualClientList($uid)
        {
            $params['uid'] = $uid;
            $response = \BC\Tools\BossApi::GetUsualClientList($params);

            if($response['code']!='SUCCESS')
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:GetUsualClientList');
            }
            else
            {
                $response = $response['data'];
            }
            return $response;
        }
        /**
         * 获取会员的所有优惠券信息 njz20150703
         *
         * @param $uid 会员ID
         * @return mixed
         */
        public static function GetMyCoupon($uid)
        {
            $ApiRequest = ['data'=>[
                'uid'=>$uid,
            ]];
//            if(true)
//            {
//                $ApiReturn = [
//                    "code"=>"100000",
//                    "message"=>"OK",
//                    "data"=>[
//                        [
//                            "CouponID"=> 1, //优惠券ID 必有 唯一标识符
//                            "CouponCode"=> '1000001', //优惠券码 必有
//                            "Money"=> 50, //面值 必有 大于0的长整形，形如：100.99
//                            "Desc"=>"仅限签证频道使用", //使用摘要描述
//                            "Begin"=>"2015-06-01", //有效期：开始日期（含当天）
//                            "End"=>"2015-09-01", //有效期：结束日期（含当天）
//                            "Status"=> 0, //状态 0=>待使用 1=>已使用 2=>已过期
//                            "TradeOrderID"=> 0, //主订单ID 若状态为“已使用”时，存储主单ID
//                            "UseDate"=> "0", //若状态为“已使用”时，存储使用日期
//                            "FavorMoney"=> 0, //若状态为“已使用”时，存储订单中优惠的金额。理论上此值 应该小于优惠券的面值
//                            "LowerLimit"=> 3580, //金额下限   满 LowerLimit 减 Money
//                            "ConditionLimitStatus"=> 0, //发放条件限制   0：无限制  1：按品类+国家限制 2：按商品限制
//                            "ProductTypes"=> "", //品类（商品类型） 以逗号分隔
//                            "CountryLimitStatus"=> 0, //国家限定类型 0：无限制 1：限指定国家 2：除指定国家以外
//                            "CountryCodes"=> "", //国家列表  以逗号分隔
//                            "ProductLimitStatus"=> 1, //单品限定类型  1：限指定商品 2：除指定商品外
//                            "ProductCodes"=> '' //商品列表 以逗号分隔
//                        ],[
//                            "CouponID"=> 2, //优惠券ID 必有 唯一标识符
//                            "CouponCode"=> '1000002', //优惠券码 必有
//                            "Money"=> 200, //面值 必有 大于0的长整形，形如：100.99
//                            "Desc"=>"仅限签证频道使用", //使用摘要描述
//                            "Begin"=>"2015-07-01", //有效期：开始日期（含当天）
//                            "End"=>"2015-09-21", //有效期：结束日期（含当天）
//                            "Status"=> 0, //状态 0=>待使用 1=>已使用 2=>已过期
//                            "TradeOrderID"=> 0, //主订单ID 若状态为“已使用”时，存储主单ID
//                            "UseDate"=> "0", //若状态为“已使用”时，存储使用日期
//                            "FavorMoney"=> 0, //若状态为“已使用”时，存储订单中优惠的金额。理论上此值 应该小于优惠券的面值
//                            "LowerLimit"=> 3000, //金额下限   满 LowerLimit 减 Money
//                            "ConditionLimitStatus"=> 1, //发放条件限制   0：无限制  1：按品类+国家限制 2：按商品限制
//                            "ProductTypes"=> "1,51", //品类（商品类型） 以逗号分隔
//                            "CountryLimitStatus"=> 0, //国家限定类型 0：无限制 1：限指定国家 2：除指定国家以外
//                            "CountryCodes"=> "", //国家列表  以逗号分隔
//                            "ProductLimitStatus"=> 1, //单品限定类型  1：限指定商品 2：除指定商品外
//                            "ProductCodes"=> '' //商品列表 以逗号分隔
//                        ],[
//                            "CouponID"=> 3, //优惠券ID 必有 唯一标识符
//                            "CouponCode"=> '1000003', //优惠券码 必有
//                            "Money"=> 300, //面值 必有 大于0的长整形，形如：100.99
//                            "Desc"=>"仅限签证频道使用", //使用摘要描述
//                            "Begin"=>"2015-06-21", //有效期：开始日期（含当天）
//                            "End"=>"2015-09-11", //有效期：结束日期（含当天）
//                            "Status"=> 0, //状态 0=>待使用 1=>已使用 2=>已过期
//                            "TradeOrderID"=> 0, //主订单ID 若状态为“已使用”时，存储主单ID
//                            "UseDate"=> "2015-08-01", //若状态为“已使用”时，存储使用日期
//                            "FavorMoney"=> 0, //若状态为“已使用”时，存储订单中优惠的金额。理论上此值 应该小于优惠券的面值
//                            "LowerLimit"=> 3260, //金额下限   满 LowerLimit 减 Money
//                            "ConditionLimitStatus"=> 1, //发放条件限制   0：无限制  1：按品类+国家限制 2：按商品限制
//                            "ProductTypes"=> "1,51", //品类（商品类型） 以逗号分隔
//                            "CountryLimitStatus"=> 1, //国家限定类型 0：无限制 1：限指定国家 2：除指定国家以外
//                            "CountryCodes"=> "133,134", //国家列表  以逗号分隔
//                            "ProductLimitStatus"=> 1, //单品限定类型  1：限指定商品 2：除指定商品外
//                            "ProductCodes"=> '' //商品列表 以逗号分隔
//                        ],[
//                            "CouponID"=> 4, //优惠券ID 必有 唯一标识符
//                            "CouponCode"=> '1000004', //优惠券码 必有
//                            "Money"=> 400, //面值 必有 大于0的长整形，形如：100.99
//                            "Desc"=>"仅限签证频道使用", //使用摘要描述
//                            "Begin"=>"2015-06-12", //有效期：开始日期（含当天）
//                            "End"=>"2015-09-24", //有效期：结束日期（含当天）
//                            "Status"=> 1, //状态 0=>待使用 1=>已使用 2=>已过期
//                            "TradeOrderID"=> 0, //主订单ID 若状态为“已使用”时，存储主单ID
//                            "UseDate"=> "0", //若状态为“已使用”时，存储使用日期
//                            "FavorMoney"=> 0, //若状态为“已使用”时，存储订单中优惠的金额。理论上此值 应该小于优惠券的面值
//                            "LowerLimit"=> 499, //金额下限   满 LowerLimit 减 Money
//                            "ConditionLimitStatus"=> 1, //发放条件限制   0：无限制  1：按品类+国家限制 2：按商品限制
//                            "ProductTypes"=> "1,51", //品类（商品类型） 以逗号分隔
//                            "CountryLimitStatus"=> 2, //国家限定类型 0：无限制 1：限指定国家 2：除指定国家以外
//                            "CountryCodes"=> "133,134", //国家列表  以逗号分隔
//                            "ProductLimitStatus"=> 1, //单品限定类型  1：限指定商品 2：除指定商品外
//                            "ProductCodes"=> '' //商品列表 以逗号分隔
//                        ],[
//                            "CouponID"=> 5, //优惠券ID 必有 唯一标识符
//                            "CouponCode"=> '1000005', //优惠券码 必有
//                            "Money"=> 500, //面值 必有 大于0的长整形，形如：100.99
//                            "Desc"=>"仅限签证频道使用", //使用摘要描述
//                            "Begin"=>"2015-06-15", //有效期：开始日期（含当天）
//                            "End"=>"2015-09-26", //有效期：结束日期（含当天）
//                            "Status"=> 2, //状态 0=>待使用 1=>已使用 2=>已过期
//                            "TradeOrderID"=> 0, //主订单ID 若状态为“已使用”时，存储主单ID
//                            "UseDate"=> "0", //若状态为“已使用”时，存储使用日期
//                            "FavorMoney"=> 0, //若状态为“已使用”时，存储订单中优惠的金额。理论上此值 应该小于优惠券的面值
//                            "LowerLimit"=> 3300, //金额下限   满 LowerLimit 减 Money
//                            "ConditionLimitStatus"=> 2, //发放条件限制   0：无限制  1：按品类+国家限制 2：按商品限制
//                            "ProductTypes"=> "1,51", //品类（商品类型） 以逗号分隔
//                            "CountryLimitStatus"=> 0, //国家限定类型 0：无限制 1：限指定国家 2：除指定国家以外
//                            "CountryCodes"=> "", //国家列表  以逗号分隔
//                            "ProductLimitStatus"=> 1, //单品限定类型  1：限指定商品 2：除指定商品外
//                            "ProductCodes"=> '20,21' //商品列表 以逗号分隔
//                        ],[
//                            "CouponID"=> 6, //优惠券ID 必有 唯一标识符
//                            "CouponCode"=> '1000005', //优惠券码 必有
//                            "Money"=> 600, //面值 必有 大于0的长整形，形如：100.99
//                            "Desc"=>"仅限签证频道使用", //使用摘要描述
//                            "Begin"=>"2015-06-25", //有效期：开始日期（含当天）
//                            "End"=>"2015-09-13", //有效期：结束日期（含当天）
//                            "Status"=> 2, //状态 0=>待使用 1=>已使用 2=>已过期
//                            "TradeOrderID"=> 0, //主订单ID 若状态为“已使用”时，存储主单ID
//                            "UseDate"=> "0", //若状态为“已使用”时，存储使用日期
//                            "FavorMoney"=> 0, //若状态为“已使用”时，存储订单中优惠的金额。理论上此值 应该小于优惠券的面值
//                            "LowerLimit"=> 3300, //金额下限   满 LowerLimit 减 Money
//                            "ConditionLimitStatus"=> 2, //发放条件限制   0：无限制  1：按品类+国家限制 2：按商品限制
//                            "ProductTypes"=> "1,51", //品类（商品类型） 以逗号分隔
//                            "CountryLimitStatus"=> 0, //国家限定类型 0：无限制 1：限指定国家 2：除指定国家以外
//                            "CountryCodes"=> "", //国家列表  以逗号分隔
//                            "ProductLimitStatus"=> 2, //单品限定类型  1：限指定商品 2：除指定商品外
//                            "ProductCodes"=> '20,21' //商品列表 以逗号分隔
//                        ]
//                    ]
//                ];
//            }
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app_php',$ApiRequest,'Member_GetAllCoupon',0,0,'','get');

            if(!empty($ApiReturn) && $ApiReturn['code']=='100000')
            {
                return $ApiReturn['data']['list'];
            }
            else
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:Member_GetAllCoupon');
            }
        }

        /**
         * 兑换优惠券（激活优惠券） njz20150703
         *
         * @param $uid
         * @param $CouponCode
         * @return mixed
         */
        public static function ActivateCoupon($uid,$CouponCode)
        {
            $ApiRequest = ['data'=>[
                'uid'=>$uid,
                'CouponCode'=>$CouponCode,
            ]];

//            if(true)
//            {
//                $ApiReturn = [
//                    "code"=>"100000",
//                    "message"=>"OK",
//                    "data"=>[
//                            "CouponID"=> 10, //优惠券ID 必有 唯一标识符
//                            "CouponCode"=> 'aaabbb123123', //优惠券码 必有
//                            "Money"=> 99, //面值 必有 大于0的长整形，形如：100.99
//                            "Desc"=>"全场通用", //使用摘要描述
//                            "Begin"=>"2015-06-01", //有效期：开始日期（含当天）
//                            "End"=>"2015-08-01", //有效期：结束日期（含当天）
//                            "Status"=> 0, //状态 0:待使用 1:已使用 2:已过期
//                            "TradeOrderID"=>111111, //主订单ID 若状态为“已使用”时，存储主单ID
//                            "UseDate"=> "2015-07-01", //若状态为“已使用”时，存储使用日期
//                            "FavorMoney"=> "1000", //若状态为“已使用”时，存储订单中优惠的金额。理论上此值应该小于优惠券的面值
//                            "LowerLimit"=> 3300, //金额下限   满 LowerLimit 减 Money
//                            "ConditionLimitStatus"=> 2, //发放条件限制   0：无限制  1：按品类+国家限制 2：按商品限制
//                            "ProductTypes"=> "1,2,3", //品类（商品类型） 以逗号分隔
//                            "CountryLimitStatus"=>2, //国家限定类型 0：无限制 1：限指定国家 2：除指定国家以外
//                            "CountryCodes"=> "111,222,333", //国家列表  以逗号分隔
//                            "ProductLimitStatus"=> 2, //单品限定类型  1：限指定商品 2：除指定商品外
//                            "ProductCodes"=>"" //商品列表 以逗号分隔
//                    ]
//                ];
//            }
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app_php',$ApiRequest,'Member_ActivateCoupon',0,0,'','get');

            if(!empty($ApiReturn) && $ApiReturn['code']=='100000')
            {
                return $ApiReturn['data'];
            }
            else
            {
                return  $ApiReturn;
            }
        }
          /**
         * 获取领取优惠券活动批次 
         * @return mixed
         */
        public static function GetActivityCouponId()
        {
            $ApiRequest = ['data'=>''];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app_php',$ApiRequest,'Activity_GetCouponId',0,0,'','get');

            if(!empty($ApiReturn) && $ApiReturn['code']=='100000')
            {
                return $ApiReturn['data'];
            }
            else
            {
                \BC\Tools\GlobalTool::checkException(false, '获取数据失败:Activity_GetCouponId');
            }
        }
		 /**
         * 领取优惠券活动 
		 * @param $uid
         * @param $CouponCode
         * @return mixed
         * @return mixed
         */
        public static function ReceiveActivityCouponById($uid,$Couponid)
        {
             $ApiRequest = ['data'=>[
                'uid'=>$uid,
                'Couponid'=>$Couponid,
            ]];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$ApiRequest,'Member_ActivityCoupon',0,0,'','get');

            if(!empty($ApiReturn) && $ApiReturn['code']=='100000')
            {
                return $ApiReturn['data'];
            }
            else
            {
                return  $ApiReturn;
            }
        }
        //endregion
        /**
         * 签证国家列表 得到签证的总数
         * @return $country_list
         */
        public static function getCountryList()
        {
            $param['hot'] = '';
            $param['platform'] = 'pc';
            $country_list = \BC\Tools\IOTool::HttpRequestWithParams('api','country',$param,'getCountryList');
            return array_get($country_list,'data');
        }

        /**
         * 私人定制国家列表
         * @return $country_list
         */
        public static function getPlanCountryList()
        {
            $param['hot'] = '';
            $param['platform'] = 'pc';
            $country_list = \BC\Tools\IOTool::HttpRequestWithParams('api','country',$param,'getPlanCountryList');


            return array_get($country_list,'data');
        }

        /**
         * 私人定制国家列表
         * @return $country_list
         */
        public static function getPlanCountryListLimit()
        {
            $param['hot'] = '';
            $param['platform'] = 'pc';
            $country_list = \BC\Tools\IOTool::HttpRequestWithParams('api','planner',$param,'getPlanCountryListLimit');


            return array_get($country_list,'data');
        }


        /**
         *
         *  @description 规划师详细页
         *  @param $plannerid 规划师ID
         *  @return $plannerCode
         *
         */
        public static function GetPlanner( $plannerid )
        {
            $ApiRequest = ['data'=>[
                'plannerid'=>$plannerid,
            ]];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','planner',$ApiRequest,'getPlanner',0,0,'','get');
            if(!empty($ApiReturn) && $ApiReturn['code']=='100000')
            {
                return $ApiReturn['data'];
            } else {
                return  $ApiReturn;
            }
        }

        /**
         *
         *  @description 规划师的全部行程
         *  @param $plannerid 规划师ID
         *  @return $plannerCode
         *
         */
        public static function GetPlannerPlanCustomized($plannerid,$page,$count)
        {

            $ApiRequest = ['data'=>[
                'plannerid'=>$plannerid,
                'page'=>$page,
                'count'=>$count,
            ]];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','planner',$ApiRequest,'GetPlannerPlanCustomized',0,0,'','get');

            if(!empty($ApiReturn) && $ApiReturn['code']=='100000')
            {
                return $ApiReturn['data'];
            }
            else
            {
                return  $ApiReturn;
            }
        }

        /**
         *
         *  @description 规划师的全部行程
         *  @param $plannerid 规划师ID
         *  @return $plannerCode
         *
         */
        public static function GetPlannerCustomizedCountrycode($id,$idtype,$page,$count)
        {
            $ApiRequest = ['data'=>[
                'id'=>$id,
                'idtype'=>$idtype,
                'page'=>$page,
                'count'=>$count,
            ]];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','planner',$ApiRequest,'GetPlannerCustomizedCountrycode',0,0,'','get');

            if(!empty($ApiReturn) && $ApiReturn['code']=='100000')
            {
                return $ApiReturn['data'];
            } else {
                return  $ApiReturn;
            }
        }

        /**
         *
         *  @description 更多页全部行程
         *  @param $plannerid 规划师ID
         *  @return $plannerCode
         *
         */
        public static function GetAllPlanCustomizedCountry($page,$count)
        {
            $ApiRequest = ['data'=>[
                'page'=>$page,
                'count'=>$count,
            ]];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','planner',$ApiRequest,'GetAllPlanCustomizedCountry',0,0,'','get');

            if(!empty($ApiReturn) && $ApiReturn['code']=='100000')
            {
                return $ApiReturn['data'];
            } else {
                return  $ApiReturn;
            }
        }

        /**
         *
         *  @description 方案的详情
         *  @param $plannerid 规划师ID
         *  @return $plannerCode
         *
         */
        public static function GetPlanBCDetail( $planid )
        {
            $ApiRequest = ['data'=>[
                'planid'=>$planid
            ]];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','planner',$ApiRequest,'GetBCPlanDetail',0,0,'','get');
            if(!empty($ApiReturn) && $ApiReturn['code']=='100000')
            {
                return $ApiReturn['data'];
            } else {
                return  $ApiReturn;
            }
        }

        /**
         *
         *  @description 方案的详情 ONEDAY
         *  @param $plannerid 规划师ID
         *  @return $plannerCode
         *
         */
        public static function GetPlanDetail( $planid )
        {
            $ApiRequest = ['data'=>[
                'planid'=>$planid
            ]];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','planner',$ApiRequest,'GetPlanDetail',0,0,'','get');
            if(!empty($ApiReturn) && $ApiReturn['code']=='100000')
            {
                return $ApiReturn['data'];
            } else {
                return  $ApiReturn;
            }
        }
        /**
         *
         *  @description 方案的详情
         *  @param $plannerid 规划师ID
         *  @return $plannerCode
         *
         */
        public static function GetPlanIndexAD()
        {
            $ApiRequest = ['data'=>[

            ]];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','planner',$ApiRequest,'GetPlanIndexAD',0,0,'','get');

            if(!empty($ApiReturn) && $ApiReturn['code']=='100000')
            {
                return $ApiReturn['data'];
            }
            else
            {
                return  $ApiReturn;
            }
        }

        public static function GetIndexPlannerAD(){
            $ApiRequest = ['data'=>[
            ]];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','planner',$ApiRequest,'GetIndexPlannerAD',0,0,'','get');

            if(!empty($ApiReturn) && $ApiReturn['code']=='100000') {
                return $ApiReturn['data'];
            } else {
                return  $ApiReturn;
            }
        }
        public static function GetPlanAD(){
            $ApiRequest = ['data'=>[
            ]];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','planner',$ApiRequest,'GetPlanAD',0,0,'','get');
            if(!empty($ApiReturn) && $ApiReturn['code']=='100000') {
                return $ApiReturn['data'];
            } else {
                return  $ApiReturn;
            }
        }
        public static function GetAskAD(){
            $ApiRequest = ['data'=>[
            ]];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','planner',$ApiRequest,'GetAskAD',0,0,'','get');
            if(!empty($ApiReturn) && $ApiReturn['code']=='100000') {
                return $ApiReturn['data'];
            } else {
                return  $ApiReturn;
            }
        }

        public static function GetPlannerQA( $plannerid,$page,$count ){
            $ApiRequest = ['data'=>[
                'plannerid' => $plannerid,
                'page' => $page,
                'count' => $count
            ]];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','planner',$ApiRequest,'GetPlannerQA',0,0,'','get');

            if(!empty($ApiReturn) && $ApiReturn['code']=='100000') {
                return $ApiReturn['data'];
            } else {
                return  $ApiReturn;
            }
        }

        public static function createChance( $Chance ){
            $ApiRequest = ['data'=>$Chance];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','net',$ApiRequest,'createChance',0,0,'','post');
            if(!empty($ApiReturn) && $ApiReturn['code']=='100000') {
                return $ApiReturn['data'];
            } else {
                return  $ApiReturn;
            }
        }
        public static function createQuestion( $Question ){
            $ApiRequest = ['data'=>$Question];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','net',$ApiRequest,'createQuestion',0,0,'','post');

            if(!empty($ApiReturn) && $ApiReturn['code']=='100000') {
                return $ApiReturn['data'];
            } else {
                return  $ApiReturn;
            }
        }

        public static function getPlanScheduleDetails( $planid,$scheduleid ){
            $ApiRequest = ['data'=>[
                'planid' => $planid,
                'scheduleid' => $scheduleid
            ]];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','planner',$ApiRequest,'getPlanScheduleDetails',0,0,'','get');

            if(!empty($ApiReturn) && $ApiReturn['code']=='100000') {
                return $ApiReturn['data'];
            } else {
                return  $ApiReturn;
            }
        }
        public static function getIndexPlanReservation( ){
            $ApiRequest = ['data'=>array()];
            $ApiReturn = \BC\Tools\IOTool::HttpRequestWithParams('api','planner',$ApiRequest,'getIndexPlanReservation',0,0,'','get');

            if(!empty($ApiReturn) && $ApiReturn['code']=='100000') {
                return $ApiReturn['data'];
            } else {
                return  $ApiReturn;
            }
        }
    }
