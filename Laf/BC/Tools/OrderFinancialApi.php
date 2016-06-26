<?php
namespace BC\Tools;
use Illuminate\Support\Facades\Config;
/**
 * 订单系统财务数据API接口 ljs20160122
 * Class OrderFinancialApi
 * @package BC\Tools;
 */
class OrderFinancialApi {
    /**
     * 获取订单的收款数据
     * @param $TradeID 主订单ID
     * @return mixed
     */
    public static function GetFinanceArListByTradeID($TradeID){
        $data['TradeID'] = $TradeID;
        $List = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'GetFinance_ArListByTradeID');
        return array_get($List,'ResponseObj');
    }
    /**
     * 获取订单的退款数据
     * @param $OrderID 子订单ID
     * @return mixed
     */
    public static function GetFinanceRefundListByOrderID($OrderID){
        $data['OrderID'] = $OrderID;
        $List = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'GetFinance_RefundListByOrderID');
        return array_get($List,'ResponseObj');
    }
    /**
     * 获取订单的预付款数据
     * @param $OrderID 子订单ID
     * @return mixed
     */
    public static function GetFinanceAdvancePaymentListByOrderID($OrderID){
        $data['OrderID'] = $OrderID;
        $List = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'GetFinance_AdvancePaymentListByOrderID');
        return array_get($List,'ResponseObj');
    }
    /**
     * 获取订单的应付款数据
     * @param $OrderID 子订单ID
     * @return mixed
     */
    public static function GetFinanceAPListByOrderID($OrderID){
        $data['OrderID'] = $OrderID;
        $List = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'GetFinance_APListByOrderID');
        return array_get($List,'ResponseObj');
    }
    /**
     * 获取订单的变更单数据
     * @param $OrderID 子订单ID
     * @return mixed
     */
    public static function GetOrderChangeOrderListByOrderID($OrderID){
        $data['OrderID'] = $OrderID;
        $List = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'GetOrder_ChangeOrderListByOrderID');
        return array_get($List,'ResponseObj');
    }
    /**
     * 获取退款单明细
     * @param $OrderID 子订单ID
     * @return mixed
     */
    public static function GetRefundOrderDetail($OrderID){
        $data['OrderID'] = $OrderID;
        $List = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'GetRefundOrderDetail');
        return array_get($List,'ResponseObj');
    }
   /**
     * 获取收款发票数据
     * @param $TradeID 主订单ID
     * @return mixed
     */
    public static function GetArInvoiceList($TradeID){
        $data['TradeID'] = $TradeID;
        $List = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'GetArInvoiceList');
        return array_get($List,'ResponseObj');
    }
    /**
     * 取消申请发票
     * @param $ArInvoiceID  收款发票ID
     * @param $CancelBy  取消人
     * @return mixed
     */
    public static function CancelArInvoice($ArInvoiceID,$CancelBy){
        $data['ArInvoiceID'] = $ArInvoiceID;
        $data['CancelBy'] = $CancelBy;
        $result = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'CancelArInvoice');
        return $result;
    }
    /**
     * 申请发票
     * @param $TradeID  主订单ID
     * @param $InvoiceType  发票类型
     * @param $GroupNo  团号
     * @param $SettlementCustomerType  结算客户类型
     * @param $InvoiceTitle  发票抬头
     * @param $InvoiceMoney  发票金额
     * @param $CreateBy  创建人
     * @param $CurEmp_BranchID  创建人所属分公司
     * @param $CreateTime  创建时间
     * @param $Memo  备注
     * @param $IsUrgent  是否加急
     * @return mixed
     */
    public static function ApplyArInvoice($TradeID,$InvoiceType,$GroupNo,$SettlementCustomerType,$InvoiceTitle,$InvoiceMoney,$CreateBy,$CurEmp_BranchID,$CreateTime,$Memo='',$IsUrgent=false){
        $data['TradeID'] = $TradeID;
        $data['InvoiceType'] = $InvoiceType;
        $data['GroupNo'] = $GroupNo;
        $data['SettlementCustomerType'] = $SettlementCustomerType;
        $data['InvoiceTitle'] = $InvoiceTitle;
        $data['InvoiceMoney'] = $InvoiceMoney;
        $data['CreateBy'] = $CreateBy;
        $data['BranchID'] = $CurEmp_BranchID;
        $data['CreateTime'] = $CreateTime;
        $data['Memo'] = $Memo;
        $data['IsUrgent'] = $IsUrgent;
        $result = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'ApplyArInvoice');
        return $result;
    }
    /**
     * 申请退款
     * @param $TradeID  主订单ID
     * @param $OrderID  子订单ID
     * @param $RefundType  退款类型
     * @param $RefundMoney  退款金额
     * @param $OpType  操作类型
     * @param $ApplyBy  申请人
     * @param $ApplyMemo  申请备注
     * @param $Payee  分公司
     * @param $TransferBank  转账银行
     * @param $TransferCardNo  转账卡号
     * @param $TransferTime 转账时间
     * @return mixed
     */
    public static function ApplyRefundOrder($TradeID,$OrderID,$RefundType,$RefundMoney,$OpType,$ApplyBy,$ApplyMemo,$Payee,$TransferBank,$TransferCardNo,$TransferTime){
        $data['TradeId'] = $TradeID;
        $data['OrderId'] = $OrderID;
        $data['RefundType'] = $RefundType;
        $data['RefundMoney'] = $RefundMoney;
        $data['OpType'] = $OpType;
        $data['ApplyBy'] = $ApplyBy;
        $data['ApplyMemo'] = $ApplyMemo;
        $data['Payee'] = $Payee;
        $data['TransferBank'] = $TransferBank;
        $data['TransferCardNo'] = $TransferCardNo;
        $data['TransferTime'] = $TransferTime;
        $result = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'ApplyRefundOrder');
        return $result;
    }
    /**
     * 获取成本明细
     * @param $OrderID 子订单ID
     * @return mixed
     */
    public static function GetCostDetail($OrderID){
        $data['OrderID'] = $OrderID;
        $List = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'GetCostDetail');
        return array_get($List,'ResponseObj');
    }
    /**
     * 获取成本服务项添加列表
     * @return mixed
     */
    public static function GetOrderServiceCostItemList(){
        $List = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',[],'GetOrderServiceCostItemList');
        return array_get($List,'ResponseObj');
    }
    /**
     * 保存成本明细
     * @param $data 保存数据
     * @return mixed
     */
    public static function SaveCostDetail($data){
        $result = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'SaveCostDetail');
        return $result;
    }
    /**
     * 批量修改订单成本
     * @param $OrderIDs 子订单号
     * @param $AdultCost 成人成本单价
     * @param $ChildCost 儿童成本单价
     * @param $SmallChildCost 0-12岁成本单价
     * @param $EmpNo 操作人
     * @return mixed
     */
    public static function BatchChangeOrderCost($OrderIDs,$AdultCost,$ChildCost,$SmallChildCost,$EmpNo){
        $data['OrderIDs'] = $OrderIDs;
        $data['AdultCost'] = $AdultCost;
        $data['ChildCost'] = $ChildCost;
        $data['SmallChildCost'] = $SmallChildCost;
        $data['EmpNo'] = $EmpNo;
        $result = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'BatchChangeOrderCost');
        return $result;
    }
    /**
     * 申请变更单
     * @param $data 保存数据
     * @return mixed
     */
    public static function ApplyCostChangeOrder($data){
        $result = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'ApplyCostChangeOrder');
        return $result;
    }
    /**
     * 获取待借款数据
     * @param $data 查询数据
     * @return mixed
     */
    public static function GetToLendDataList($data){
        $List = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'GetToLendDataList');
        return array_get($List,'ResponseObj');
    }
    /**
     * 获取供应商结算信息
     * @param $SuppID 供应商ID
     * @return mixed
     */
    public static function GetSuppSettlementBySuppID($SuppID){
        $data['SuppID'] = $SuppID;
        $List = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'GetSuppSettlementBySuppID');
        return array_get($List,'ResponseObj');
    }
    /**
     * 获取待核销数据
     * @param $data 查询数据
     * @return mixed
     */
    public static function GetToChargeOffDataList($data){
        $List = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'GetToChargeOffDataList');
        return array_get($List,'ResponseObj');
    }
    /**
     * 初始化申请预付款单数据
     * @param $OrderIDS 子订单ID字符串
     * @param $ApItemType 支款项目
     * @return mixed
     */
    public static function InitAdvanceBill($OrderIDS,$ApItemType){
        $data['OrderIDs'] = $OrderIDS;
        $data['ApItemType'] = $ApItemType;
        $result = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'InitAdvanceBill');
        return $result;
    }
    /**
     * 申请预付款单
     * @param $data 申请数据
     * @return mixed
     */
    public static function ApplyAdvanceBill($data){
        $result = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'ApplyAdvanceBill');
        return $result;
    }
    /**
     * 获取可应付款的预付款单列表
     * @param $OrderIDS 子订单ID字符串
     * @return mixed
     */
    public static function GetChooseAdvancePaymentData($OrderIDS){
        $data['OrderIDs'] = $OrderIDS;
        $result = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'GetChooseAdvancePaymentData');
        return $result;
    }
    /**
     * 初始化申请应付款单数据
     * @param $OrderIDS 子订单ID字符串
     * @param $ApItemType 付款项目类型
     * @param $AdvancePaymentList 预付款列表
     * @param $InvoiceList 支款项目
     * @return mixed
     */
    public static function InitAccountPayableBill_New($OrderIDS,$ApItemType,$AdvancePaymentList,$InvoiceList)
    {
        $data['OrderIDs'] = $OrderIDS;
        $data['ApItemType'] = $ApItemType;
        $data['AdvancePaymentList'] = $AdvancePaymentList;
        $data['InvoiceList'] = $InvoiceList;
        $result = \BC\Tools\IOTool::OrderManageFinancialRequest('financial', 'finance', $data, 'InitAccountPayableBill_New');
        return $result;
    }
    /**
     * 初始化申请核销数据
     * @param $ApItemType 付款项目类型
     * @param $AdvancePaymentList 预付款列表
     * @param $InvoiceList 支款项目
     * @return mixed
     */
    public static function InitAccountPayableBill_Cav($ApItemType,$AdvancePaymentList,$InvoiceList)
    {
        $data['ApItemType'] = $ApItemType;
        $data['AppCodes'] = $AdvancePaymentList;
        $data['InvoiceList'] = $InvoiceList;
        $result = \BC\Tools\IOTool::OrderManageFinancialRequest('financial', 'finance', $data, 'InitAccountPayableBill_Cav');
        return $result;
    }
    /**
     * 申请应付款款单
     * @param $data 申请数据
     * @return mixed
     */
    public static function ApplyAccountPayableBill($data){
        $result = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'ApplyAccountPayableBill');
        return $result;
    }
     /* 成本单导出
     * @param $data 成本单导出
     * @return mixed
     */
    public static function GetChengBenDanList($data){
        $result = \BC\Tools\IOTool::OrderManageFinancialRequest('financial','finance',$data,'GetVisaCostSheet');
        return $result;
    }
}
