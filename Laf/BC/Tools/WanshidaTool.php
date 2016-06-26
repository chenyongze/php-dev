<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2015/10/27
 * Time: 15:43
 */

namespace BC\Tools;


class WanshidaTool
{

    /**
     * @todo 匹配参与万事达签证商品列表
     *
     * @author lijunshuai
     * @param array $visalist 签证商品列表
     * @param array $activitylist 活动列表
     * @param int $promotionid 活动ID
     * @return string
     */
    public static function matchingVisaList($visalist,$activitylist,$promotionid)
    {
        if(!$visalist){
            return $visalist;
        }
        if(!$activitylist){
            return $visalist;
        }
        //循环签证列表
        foreach($visalist as $visakey=>$visavalue){
            //循环活动列表
            foreach($activitylist as $actvalue){
                //拆分商品ID
                $goodidlist = explode(',', $actvalue['goodidlist']);
                //匹配活动（活动ID相同、商品参与该活动）
                if($promotionid == $actvalue['promotionid'] && in_array($visavalue['prodid'],$goodidlist)){
                    $visalist[$visakey]['promotionid'] = $promotionid; //活动ID
                    $visalist[$visakey]['promotionname'] = $actvalue['promotionname']; //活动名称
                    $visalist[$visakey]['advertisement'] = $actvalue['advertisement']; //活动宣传语
                }
            }
        }
        return $visalist;
    }
     /**
     * @todo 匹配参与万事达签证商品套餐
     *
     * @author lijunshuai
     * @param array $packlist 签证商品套餐列表
     * @param array $activitylist 活动列表
     * @param int $promotionid 活动ID
     * @return string
     */
    public static function matchingVisaPack($packlist,$activitylist,$promotionid)
    {
        //获取减免的活动信息
        $promotioninfo = array();
        //循环活动列表
        foreach($activitylist as $actvalue){
            //匹配活动（活动ID相同）
            if($promotionid == $actvalue['promotionid']){
                $promotioninfo = $actvalue;
                break;
            }
        }
        //不存在直接返回套餐列表
        if(!$promotioninfo){
            return array("promotion"=>$promotioninfo,'packlist'=>$packlist);
        }
        //循环套餐列表
        foreach($packlist as $packkey=>$packvalue){
            //循环活动套餐列表
            foreach($promotioninfo['packagelist'] as $packagevalue){
                //匹配活动套餐ID
                if($packvalue['packageid'] == $packagevalue['packageid']){
                   //循环套餐价位列表
                   foreach($packvalue['skuinfo'] as $skuinfokey=>$skuinfovalue){
                        //循环活动套餐减免价格列表
                        foreach($packagevalue['couponpricelist'] as $couponpricelistvalue){
                            if($couponpricelistvalue['type'] == $skuinfovalue['type']){
                                $packlist[$packkey]['skuinfo'][$skuinfokey]['couponprice'] = $couponpricelistvalue['couponprice'];
                            }
                        }
                   }
                }
            }
        }
        return array("promotion"=>$promotioninfo,'packlist'=>$packlist);
    }
	/**
     * @todo 根据套餐ID获取优惠信息
     *
     * @author lijunshuai
     * @param array $activitylist 活动列表
     * @param int $promotionid 活动ID
	 * @param int $packid 活动ID
     * @return string
     */
    public static function matchingVisaPackByPackid($activitylist,$promotionid,$packid)
    {
        //获取减免的活动信息
        $promotioninfo = array();
        //循环活动列表
        foreach($activitylist as $actvalue){
            //匹配活动（活动ID相同）
            if($promotionid == $actvalue['promotionid']){
                $promotioninfo = $actvalue;
                break;
            }
        }
        //不存在返回false
        if(!$promotioninfo){
            return false;
        }
        //循环活动套餐列表
		$packinfo = array();
        foreach($promotioninfo['packagelist'] as $packagevalue){
			//匹配活动套餐ID
			if($packid == $packagevalue['packageid']){
				$packinfo = $packagevalue;	  
			}
       }
        return $packinfo;
    }
}
