<?php
/**
 * Created by PhpStorm.
 * User: njz
 * Date: 14-9-25
 * Time: 下午2:37
 */

namespace BC\Tools;


class UsualConst
{
    //网站二级域名HOST
    const WWW_HOST = "http://www.baicheng.com/";
    const VISA_HOST = "http://visa.baicheng.com/";
    const TEMAI_HOST = "http://temai.baicheng.com/";
    const DUJIA_HOST = "http://dujia.baicheng.com/";
    const G_HOST = "http://g.baicheng.com/";
    const PASSPORT_HOST = "http://passport.baicheng.com/";
    const PAY_HOST = "http://pay.baicheng.com/";
    const CMS_HOST = "http://cms.baicheng.com/";

    //各分公司地址
    const BJ_ADDRESS = "北京市朝阳区通惠河畔文化创意产业园1131号君天大厦二层  【电话：400-151-6666 ；邮箱：kehufuwu@baicheng.com ；邮编：100023】";
    const SH_ADDRESS = "上海市黄浦区汉口路400号华盛大厦8层801室（地铁十号线、二号线，南京东路站出4号口左转，延山西南路南行100米，路口右转到即到，汉口路400号）  【电话：021-61961258 ；邮编：200001】";
    const GZ_ADDRESS = "广州市越秀区建设六马路33号宜安广场1708室  【电话：020-83633779 ；邮编：510060】";
    const CD_ADDRESS = "成都市武侯区人民南路四段27号商鼎国际1栋2单元1004号  【电话：028-85567805 ；邮箱：chengdu@baicheng.com  邮编：610012】";
    const SY_ADDRESS = "沈阳市和平区太原南街18号万达新天地（24-01室） 【电话：024-31078821 31078823 31078827 ；邮编：110001】";


    //第三方合作固定URL
    const EXPRESS_SHUNFENG_URL = "http://www.sf-express.com/cn/sc/dynamic_functions/waybill/#search/bill-number"; //快件查询-顺风
    const EXPRESS_ZY_URL = "http://www.zeny-express.com/index.php?c=chaxun&a=yundan"; //快件查询-速递追踪-上海增联物流有限公司
    const QINIU_IMG_HOST = "http://baicheng-cms.qiniucdn.com/"; //cdn：七牛

    public static $AllDomainConst = array(
        'WWW_HOST' => self::WWW_HOST,
        'VISA_HOST' => self::VISA_HOST,
        'TEMAI_HOST' => self::TEMAI_HOST,
        'DUJIA_HOST' => self::DUJIA_HOST,
        'G_HOST' => self::G_HOST,
        'PASSPORT_HOST' => self::PASSPORT_HOST,
        'PAY_HOST' => self::PAY_HOST,
        'CMS_HOST' => self::CMS_HOST
    );
    public static $BCAddress = array(
        'BJ_ADDRESS' => self::BJ_ADDRESS,
        'SH_ADDRESS' => self::SH_ADDRESS,
        'GZ_ADDRESS' => self::GZ_ADDRESS,
        'CD_ADDRESS' => self::CD_ADDRESS,
        'SY_ADDRESS' => self::SY_ADDRESS,
    );
    public  static function GetTradeOrderStatusName($tradeOrderStatus)
    {
        $tradeOrderStatusName='';
        switch ((int)$tradeOrderStatus) {
            case 1:
                $tradeOrderStatusName= '新订单';
                break;
            case 2:
                $tradeOrderStatusName= '待确认';
                break;
            case 3:
                $tradeOrderStatusName= '等待付款';
                break;
            case 4:
                $tradeOrderStatusName= '已部分支付';
                break;
            case 5:
                $tradeOrderStatusName= '已全款支付';
                break;
            case 6:
            case 9:
            case 10:
            case 11:
            case 12:
            case 13:
                $tradeOrderStatusName= '处理中';
                break;
            case 7:
                $tradeOrderStatusName= '已取消';
                break;
            case 8:
                $tradeOrderStatusName= '已完成';
                break;
        }
        return $tradeOrderStatusName;
    }


    public  static function GetProductTypeName($ProductTypeID)
    {
        $Name='';
        switch ((int)$ProductTypeID) {
            case 1:
                $Name= '签证';
                break;
            case 2:
                $Name= '跟团游';
                break;
            case 3:
                $Name= '自由行';
                break;
            case 4:
                $Name= '邮轮';
                break;
            case 6:
                $Name= '酒店';
                break;
            case 7:
                $Name= '机票';
                break;
            case 21:
                $Name= '保险';
                break;
            case 22:
                $Name= '交通服务';
                break;
            case 27:
                $Name= '旅游装备';
                break;
            case 29:
                $Name= '景点门票';
                break;
            case 46:
                $Name= '其他';
                break;
            case 47:
                $Name= '私属定制';
                break;
            case 51:
                $Name= '单项服务';
                break;
            case 53:
                $Name= '国际租车';
                break;
            case 50:
                $Name= '一日/半日游';
                break;
            case 54:
                $Name= '游轮游船';
                break;
            case 55:
                $Name= '当地游览';
                break;
            case 56:
                $Name= '机场接送';
                break;
            case 57:
                $Name= '旅游书籍';
                break;
            case 58:
                $Name= '演出表演';
                break;
            case 59:
                $Name= '境外通讯';
                break;
            case 60:
                $Name= '导游服务';
                break;
            case 61:
                $Name= '特惠购物';
                break;
            case 62:
                $Name= '特色餐饮';
                break;
            case 63:
                $Name= '体育赛事';
                break;
            case 64:
                $Name= '旅游装备';
                break;
            case 65:
                $Name= '医疗美容';
                break;
            case 66:
                $Name= '度假产品';
                break;
            default:
                $Name= '未知';
                break;
        }
        return $Name;
    }


} 