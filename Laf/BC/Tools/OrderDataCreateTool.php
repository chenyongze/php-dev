<?php
/**
 * Created by PhpStorm.
 * User: ljs
 * Date: 2016/01/15
 * Time: 15:43
 */

namespace BC\Tools;
use OrderManageSystem\models\Prod_ProductBase;
use OrderManageSystem\models\Web_Country;
use OrderManageSystem\models\Web_Continent;

class OrderDataCreateTool
{

    /**
     * @todo 生成订单组号
     *
     * @author lijunshuai
     * @param int $ProductType 产品类型
     * @param array $BranchCode 分公司枚举
     * @param int $productID 产品id
     * @param int $orderFrom 订单来源
     * @param int $custSourceType 客户来源类型
     * @param int $personCount 总人数
     * @param int $DateTime 订单创建时间
     * @param int $cid 国家ID
     * @return string
     */
    public static function CreateGroupNo($ProductType,$BranchCode,$productID,$orderFrom,$custSourceType,$personCount,$DateTime,$cid){
        //通过产品ID获取产品详情
        $productInfo = Prod_ProductBase::GetProductInfoById($productID);
        //产品抬头
        $productTitle = self::GetProductTypeTitile($ProductType);
        //判断国家ID是否为空
        if (empty($cid)) {
            $countryID = empty($productInfo->CountryId) ? 0 : $productInfo->CountryId;    //所属国家ID
        }else{
            $countryID = $cid;  //所属国家ID
        }
        //获取国家信息
        $countryInfo = Web_Country::GetCountryById($countryID);
        if (empty($cid)) {
            $continentID = empty($productInfo->ContinentId) ? 0 : $productInfo->ContinentId; //所属大洲ID
        }else{
            $continentID = empty($countryInfo->ContinentID)?0:$countryInfo->ContinentID;    //所属大洲ID
        }
        //获取大洲信息
        $continentInfo = Web_Continent::GetContinentInfoById($continentID);

        $continentNameEn = empty($continentInfo->ForShort) ? "未知大洲" : $continentInfo->ForShort; // 大洲英文名
        $countryNameEn = empty($countryInfo->ID) ? "未知国家" : $countryInfo->NameEn;    //国家英文名
        $countryNameCn = empty($countryInfo->ID) ? "未知国家" : $countryInfo->NameCn;   //国家中文名
        $countryForShort = empty($countryInfo->ID) ? $countryNameEn : $countryInfo->ForShort;  //国家简写

        //客户来源
        $custSource = EnumTool::$CustSourceEnum[$custSourceType];
        //渠道来源
        $sourceChn = ($orderFrom == 1) ? "CRM" : "WEB";
        //分公司简写
        $BranchShort = isset(EnumTool::$Com_Branch_Short[$BranchCode])?EnumTool::$Com_Branch_Short[$BranchCode]:$BranchCode;
        //团号日期
        $groupNoDate = empty($DateTime)?date("yyyyMMdd",strtotime($DateTime)):date("yyyyMMdd");
        //生成订单号
        switch ($ProductType) {
            //附加产品
            case 8: return $BranchShort."-".$productTitle."-".$productInfo->SubHead."-".$groupNoDate."-".$custSource."-".$sourceChn."-".$personCount.'P';
            //签证
            case 1: return $BranchShort."-".$productTitle."-".self::GetVisaPartitionEnum($countryNameCn)."-".$continentNameEn."-".$countryNameEn."-".$groupNoDate."-".$custSource."-".$sourceChn."-".$personCount.'P';
            //保险
            case 21: return $BranchShort."-".$productTitle."-".$continentNameEn."-".$countryNameEn."-".$groupNoDate."-".$custSource."-".$sourceChn."-".$personCount.'P';
            //团队游（在保存时对出发日期和供应商做替换）
            case 2: return $BranchShort."-TZ-".$countryNameEn."-".$custSource."-".$sourceChn."-[UseDate]-".$personCount.'P-[NoSupplyName]';
            default: return $BranchShort."-".$productTitle."-".$continentNameEn."-".$countryNameEn."-".$groupNoDate."-".$custSource."-".$sourceChn."-".$personCount.'P';
        }
    }
    /**
     * @todo 获取产品类型抬头
     *
     * @author lijunshuai
     * @param int $ProductType 产品类型
     * @return string
     */
    private static function GetProductTypeTitile($ProductType){
        switch($ProductType){
            case 1:  return "V";  //签证
            case 2:  return "TZ"; //跟团游
            case 3:  return "F";  //自由行
            case 6:  return "H";  //酒店
            case 7:  return "T";  //机票
            case 8 : return "Other"; //附加商品
            case 21: return "BX"; //保险
            case 27: return "SS"; //特色服务
            case 29: return "Ticket"; //门票
            case 36: return "Y";  //青年旅社卡
            case 37: return "D";  //香港驾照
            case 50: return "DT";  //日游
            case 56: return "DJ";   //接送机
            default: return "Other"; //其他
        }
    }    /**
     * @todo 获取国家是否为冷门
     *
     * @author lijunshuai
     * @param int $countryNameCn 国家名称
     * @return string
     */
    private static function GetVisaPartitionEnum($countryNameCn){
        $BigVisaCountry = ['法国','意大利','德国','瑞士','奥地利','西班牙','荷兰','比利时','希腊','丹麦','瑞典','挪威','芬兰','葡萄牙','马耳他','波兰','匈牙利','冰岛','捷克','英国','爱尔兰','大溪地','美国','加拿大','澳大利亚','新西兰','南非','土耳其'];
        $SmailVisaCountry = ['泰国','马来西亚','新加坡','日本','韩国','菲律宾','越南','柬埔寨','老挝','缅甸','孟加拉','尼泊尔','斯里兰卡','印尼','文莱','印度','入台证','阿联酋','俄罗斯','埃及','肯尼亚'];
       if(in_array($countryNameCn,$BigVisaCountry)){
           return 'D';
       }elseif(in_array($countryNameCn,$SmailVisaCountry)){
           return 'X';
       }else{
           return 'L';
       }
    }
}
