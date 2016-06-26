<?php
/**
 * Created by PhpStorm.
 * User: njz
 * Date: 14-9-24
 * Time: 下午3:55
 */
namespace BC\Tools;

use Whoops\Example\Exception;

class AfterPay
{

    /**
     * 在线支付成功后通知boss
     * author:njz 20140924
     * @param int $TradeID 交易订单ID
     * @param float $PaidMoney 当次支付金额
     * @param string $PaymentBy 支付人名称
     * @param date $PaymentTime 支付时间
     * @param int $PaymentType 支付方式（1招行信用卡2.快钱-普通客户3.快钱-信用卡4.支付宝-网站5.支付宝-移动）
     * @param sting $CardNo 付款卡号
     * @param sting $PaymentNo 支付流水号
     * @return \Illuminate\Support\MessageBag|string
     */
    public static function AfterPay($TradeID, $PaidMoney, $PaymentBy, $PaymentTime, $PaymentType, $CardNo, $PaymentNo)
    {
        $TradeID = trim($TradeID);
        $PaidMoney = trim($PaidMoney);
        $PaymentBy = trim($PaymentBy);
        $PaymentTime = trim($PaymentTime);
        $PaymentType = trim($PaymentType);
        $CardNo = trim($CardNo);
        $PaymentNo = trim($PaymentNo);

        //第一步，验证数据，如果数据格式不正确，则直接返回；若考虑最大化记录支付数据，可将此注释掉，数据校验交由调用方处理
        $validator = \Validator::make(
            array(
                'tradeid' => $TradeID,
                'paidmoney' => $PaidMoney,
                'paymenttime' => $PaymentTime,
            ),
            array('tradeid' => array('required', 'integer'),
                'paidmoney' => array('required', 'min:0'),
                'paymenttime' => array('required', 'date'),

            )
        );
        if ($validator->fails()) {
            return $validator->messages();
        }
        //第二步：组织要调用服务接口的数据
        $inputdata = array(
            'TradeID' => $TradeID,
            'PaidMoney' => $PaidMoney,
            'PaymentBy' => $PaymentBy,
            'PaymentTime' => $PaymentTime,
            'PaymentType' => $PaymentType,
            'CardNo' => $CardNo,
            'PaymentNo' => $PaymentNo,
        );
        $method = 'FinishPay';
        $service_output = null;

        $service_output = WebService::execute($method, $inputdata, 'VisaAPI_Config');


        return json_encode($service_output);
    }

}