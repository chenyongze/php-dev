<?php
namespace BC\Tools;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
     /**
     * 供应商系统接口
     */
class SupplierApi {

    /**
     * 获取境外紧急联系人列表 ljs20151215
     * http://wiki.baicheng.com/index.php/Supplier-system#.E5.A2.83.E5.A4.96.E7.B4.A7.E6.80.A5.E8.81.94.E7.B3.BB.E4.BA.BA.E5.88.97.E8.A1.A8
     * @return mixed
     */
    public static function Http_GetFroeignEmergencyContactList(){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getFroeignEmergencyContactList');
        return array_get($HttpReturn,'data');
    }
    /**
     * 获取境外紧急联系人信息详情 ljs20151215
     * http://wiki.baicheng.com/index.php/Supplier-system#.E8.8E.B7.E5.8F.96.E5.A2.83.E5.A4.96.E7.B4.A7.E6.80.A5.E8.81.94.E7.B3.BB.E4.BA.BA.E4.BF.A1.E6.81.AF.E8.AF.A6.E6.83.85
     * @param $contact_id 紧急联系人编号
     * @return mixed
     */
    public static function Http_GetFroeignEmergencyContactInfo($contact_id){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
	$data['data']['contact_id'] = $contact_id;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getFroeignEmergencyContactInfo');
        return array_get($HttpReturn,'data');
    }
    /**
     * 境外紧急联系人信息维护 ljs20151216
     * http://wiki.baicheng.com/index.php/Supplier-system#.E5.A2.83.E5.A4.96.E7.B4.A7.E6.80.A5.E8.81.94.E7.B3.BB.E4.BA.BA.E4.BF.A1.E6.81.AF.E7.BB.B4.E6.8A.A4
     * @param $param 维护信息
     * @return mixed
     */
    public static function Http_UpdateFroeignEmergencyContacInfo($param){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
	$data['data'] = array_merge($data['data'],$param);
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'updateFroeignEmergencyContacInfo');
        return $HttpReturn;
    }
    /**
     * 获取接机人、送机人、司机列表 ljs20151216
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.8E.A5.E6.9C.BA.E4.BA.BA.E3.80.81.E9.80.81.E6.9C.BA.E4.BA.BA.E3.80.81.E5.8F.B8.E6.9C.BA.E5.88.97.E8.A1.A8
     * @param $service_type 类别 1 为司机，2为接机人，3为送机人
     * @return mixed
     */
    public static function Http_GetServiceList($service_type){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
	$data['data']['service_type'] = $service_type;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getServiceList');
        return array_get($HttpReturn,'data');
    }
    /**
     * 接机人、送机人、司机信息详情 ljs20151215
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.8E.A5.E6.9C.BA.E4.BA.BA.E3.80.81.E9.80.81.E6.9C.BA.E4.BA.BA.E3.80.81.E5.8F.B8.E6.9C.BA.E4.BF.A1.E6.81.AF.E8.AF.A6.E6.83.85
     * @param $service_id id编号
     * @return mixed
     */
    public static function Http_GetServiceInfo($service_id){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
	$data['data']['contact_id'] = $service_id;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getServiceInfo');
        return array_get($HttpReturn,'data');
    }
    /**
     * 接机人、送机人、司机信息维护 ljs20151216
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.8E.A5.E6.9C.BA.E4.BA.BA.E3.80.81.E9.80.81.E6.9C.BA.E4.BA.BA.E3.80.81.E5.8F.B8.E6.9C.BA.E4.BF.A1.E6.81.AF.E7.BB.B4.E6.8A.A4
     * @param $param 维护信息
     * @return mixed
     */
    public static function Http_UpdateServiceInfo($param){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
	$data['data'] = array_merge($data['data'],$param);
	//类型为司机时使用
	if(!isset($data['data']['service_plate_number'])){
            $data['data']['service_plate_number'] = '';
	}
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'updateServiceInfo');
        return $HttpReturn;
    }
    /**
     * 获取子供应商列表 ljs20151216
     * http://wiki.baicheng.com/index.php/Supplier-system#.E5.AD.90.E4.BE.9B.E5.BA.94.E5.95.86.E5.88.97.E8.A1.A8
     * @return mixed
     */
    public static function Http_GetSubSupplierList(){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getSubSupplierList');
        return array_get($HttpReturn,'data');
    }
    /**
     * 获取子供应商信息详情 ljs20151215
     * http://wiki.baicheng.com/index.php/Supplier-system#.E8.8E.B7.E5.8F.96.E5.AD.90.E4.BE.9B.E5.BA.94.E5.95.86.E4.BF.A1.E6.81.AF.E8.AF.A6.E6.83.85
     * @param $sub_supplier_id 供应商编号
     * @return mixed
     */
    public static function Http_GetSubSupplierInfo($sub_supplier_id){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
	$data['data']['sub_supplier_id'] = $sub_supplier_id;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getSubSupplierInfo');
        return array_get($HttpReturn,'data');
    }
    /**
     * 子供应商信息维护 ljs20151216
     * http://wiki.baicheng.com/index.php/Supplier-system#.E5.AD.90.E4.BE.9B.E5.BA.94.E5.95.86.E4.BF.A1.E6.81.AF.E7.BB.B4.E6.8A.A4
     * @param $param 维护信息
     * @return mixed
     */
    public static function Http_UpdateSubSupplierInfo($param){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
	$data['data'] = array_merge($data['data'],$param);
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'updateSubSupplierInfo');
        return $HttpReturn;
    }
    /**
     * 获取订单列表 ljs20151217
     * http://wiki.baicheng.com/index.php/Supplier-system#.E8.8E.B7.E5.8F.96.E8.AE.A2.E5.8D.95.E5.88.97.E8.A1.A8
     * @param $param 查询信息
     * @return mixed
     */
    public static function Http_GetSingleTradeList($param){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
	$data['data'] = array_merge($data['data'],$param);

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getSingleTradeList');
        return array_get($HttpReturn,'data');
    }
    /**
     * 获取订单详情 ljs20151216
     * http://wiki.baicheng.com/index.php/Supplier-system#.E8.8E.B7.E5.8F.96.E8.AE.A2.E5.8D.95.E8.AF.A6.E6.83.85
     * @param $orderid 订单ID
     * @param $tradetype 订单类型 1 接机，2送机，3门票，4日游
     * @return mixed
     */
    public static function Http_GetTradeInfo($orderid,$tradetype,$supplier_code=''){

        if(Session::get('suppInfo.suppCode')[0]){
            $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
            $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        }else{
            $data['data']['supplier_code'] = $supplier_code;
            $data['data']['operator_id'] = $supplier_code;
        }

	    $data['data']['order_id'] = $orderid;
	    $data['data']['trade_type'] = $tradetype;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getTradeInfo');
        return array_get($HttpReturn,'data');
    }
    /**
     * 获取订单详情(日游) 复用 lyl20160412
     * http://wiki.baicheng.com/index.php/%E7%9B%AE%E7%9A%84%E5%9C%B0%E7%B3%BB%E7%BB%9F#.E8.8E.B7.E5.8F.96.E8.AE.A2.E5.8D.95.E8.AF.A6.E6.83.85.28.E6.97.A5.E6.B8.B8.29_.E5.A4.8D.E7.94.A8
     * @param $trade_id 主订单ID
     * @param $product_id 商品ID
     * @param $system_type 1 供应商系统  2 目的地系统
     * @return mixed
     */
    public static function Http_getTradeDayTourInfo($trade_id,$product_id,$system_type='1'){
        $data['data']['uid'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['uid'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['trade_id'] = $trade_id;
        $data['data']['product_id'] = $product_id;
        $data['data']['system_type'] = $system_type;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getTradeDayTourInfo');
        return array_get($HttpReturn,'data');
    }
    /**
     * 获取操作人员列表 ljs20151217
     * http://wiki.baicheng.com/index.php/Supplier-system#.E8.8E.B7.E5.8F.96.E6.93.8D.E4.BD.9C.E4.BA.BA.E5.91.98.E5.88.97.E8.A1.A8
     * @return mixed
     */
    public static function Http_GetSingleOperatorList(){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getSingleOperatorList');
        return array_get($HttpReturn,'data');
    }
    /**
     * 添加订单快照（PHP api接口） ljs20151222
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.89.A7.E8.A1.8C.E6.B7.BB.E5.8A.A0.E8.AE.A2.E5.8D.95.E5.BF.AB.E7.85.A7.E6.93.8D.E4.BD.9C
     * @param $orderId 订单ID
     * @param $snapshotData 快照数据
     * @return mixed
     */
    public static function Http_CreateOderSnapshot($orderId,$snapshotData){
        $data['data']['order_id'] = $orderId;
	$data['data']['snapshot_data'] = $snapshotData;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app_php_snapshot',$data,'createOderSnapshot');
        return $HttpReturn;
    }
    /**
     * 获取订单快照（PHP api接口） ljs20151222
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.89.A7.E8.A1.8C.E8.8E.B7.E5.8F.96.E8.AE.A2.E5.8D.95.E5.BF.AB.E7.85.A7.E6.93.8D.E4.BD.9C
     * @param $orderId 订单IDHttp_getOrderLogList
     * @return mixed
     */
    public static function Http_GetOderSnapshotByOrderId($orderId){
        $data['data']['order_id'] = $orderId;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app_php_snapshot',$data,'getOderSnapshotByOrderId');
        return array_get($HttpReturn,'Response.snapshot_data');
    }
    /**
     * 修改订单快照状态（PHP api接口） ljs20151222
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.89.A7.E8.A1.8C.E4.BF.AE.E6.94.B9.E8.AE.A2.E5.8D.95.E5.BF.AB.E7.85.A7.E7.8A.B6.E6.80.81.E6.93.8D.E4.BD.9C
     * @param $orderId 订单ID
     * @return mixed
     */
    public static function Http_UpdateOderSnapshotStatus($orderId){
        $data['data']['order_id'] = $orderId;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app_php_snapshot',$data,'updateOderSnapshotStatus');
        return $HttpReturn;
    }
    /**
     * 执行接单操作 ljs20151224
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.89.A7.E8.A1.8C.E6.8E.A5.E5.8D.95.E6.93.8D.E4.BD.9C
     * @param $orderid 订单ID
     * @param $status 状态值
     * @return mixed
     */
    public static function Http_UpdateReceivingStatus($orderid,$status){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
	    $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
	    $data['data']['order_id'] = $orderid;
	    $data['data']['status'] = $status;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'updateReceivingStatus');
        return $HttpReturn;
    }
    /**
     * 执行接单操作(接送机几日游) lyl20160413
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.89.A7.E8.A1.8C.E6.8E.A5.E5.8D.95.E6.93.8D.E4.BD.9C_2
     * @param $trade_id 主订单ID
     * @param $product_id 商品ID
     * @param $status 状态值
     * @return mixed
     */
    public static function Http_UpdateReceivingStatusPublic($trade_id,$product_id,$status){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['trade_id'] = $trade_id;
        $data['data']['productId'] = $product_id;
        $data['data']['status'] = $status;
        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'updateReceivingStatusPublic');
        return $HttpReturn;
    }
    /**
     * 执行下单操作 hs20151228
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.89.A7.E8.A1.8C.E4.B8.8B.E5.8D.95.E6.93.8D.E4.BD.9C
     * @param $orderid 订单ID
     * @param $status 状态值
     * @return mixed
     */
    public static function Http_CreateOderPlaceStatus($info){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['order_id'] = $info['order_id'];
        $data['data']['status'] = $info['status'];
        $data['data']['remark'] = $info['remark'];
        $data['data']['service_id'] = $info['service_id'];
        $data['data']['service_type'] = $info['service_type'];

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'updatePlaceStatus');
        return $HttpReturn;
    }
    /**
     * 执行下单操作(接送机及日游) lyl20160413
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.89.A7.E8.A1.8C.E4.B8.8B.E5.8D.95.E6.93.8D.E4.BD.9C
     * @param $trade_id 主订单ID
     * @param $productId 产品ID
     * @param $status 状态值
     * @return mixed
     */
    public static function Http_updatePlaceStatusPublic($info){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['trade_id'] = $info['trade_id'];
        $data['data']['productId'] = $info['product_id'];
        $data['data']['status'] = $info['status'];
        $data['data']['remark'] = isset($info['remark'])?$info['remark']:'';
        $data['data']['service_id'] = isset($info['service_id'])?$info['service_id']:'';
        $data['data']['service_type'] = isset($info['service_type'])?$info['service_type']:'';

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'updatePlaceStatusPublic');
        return $HttpReturn;
    }
    /**
     * 上传凭证（接送机及日游） lyl20160415
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.89.A7.E8.A1.8C.E4.B8.8B.E5.8D.95.E6.93.8D.E4.BD.9C
     * @param $trade_id 主订单ID
     * @param $productId 产品ID
     * @param $status 状态值
     * @return mixed
     */
    public static function Http_uploadCertificate($info){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['trade_id'] = $info['trade_id'];
        $data['data']['product_id'] = $info['product_id'];
        $data['data']['status'] = $info['status'];
        $data['data']['certificate_filename'] = $info['certificate_filename'];
        $data['data']['certificate_filepath'] = $info['certificate_filepath'];

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'UploadCertificate');
        return $HttpReturn;
    }
    /**
     * 指派导游（日游） lyl20160415
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.89.A7.E8.A1.8C.E4.B8.8B.E5.8D.95.E6.93.8D.E4.BD.9C
     * @param $trade_id 主订单ID
     * @param $productId 产品ID
     * @param $status 状态值
     * @return mixed
     */
    public static function Http_setTour($info){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['trade_id'] = $info['trade_id'];
        $data['data']['productId'] = $info['product_id'];
        $data['data']['remark'] = isset($info['remark'])?$info['remark']:'';
        $data['data']['service_id'] = isset($info['service_id'])?$info['service_id']:'';
        $data['data']['service_type'] = isset($info['service_type'])?$info['service_type']:'';
        $data['data']['status'] = $info['status'];

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'setTour');
        return $HttpReturn;
    }
    /**
     * 执行拒单操作 lyl20160411
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.89.A7.E8.A1.8C.E4.B8.8B.E5.8D.95.E6.93.8D.E4.BD.9C
     * @param $trade_id 主单编号 
     * @param $product_id 商品编号
     * @param $judan_type 拒单类型 1.无法安排服务 2.成本错误 3.日游信息错误 4.其他
     * @param $refuse_status 拒单状态 0 未拒单，1未修改，2已修改
     * @param $remark 备注
     * @return mixed
     */
    public static function Http_setSupplierJuDan($info){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['trade_id'] = $info['trade_id'];
        $data['data']['product_id'] = $info['product_id'];
        $data['data']['judan_type'] = $info['judan_type'];
        $data['data']['refuse_status'] = $info['refuse_status'];
        $data['data']['remark'] = $info['remark'];

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'setSupplierJuDan');
        return $HttpReturn;
    }
    /**
     * 获取服务提供者(司机、接送机人或子供应商)列表 hs20151228
     * http://wiki.baicheng.com/index.php/Supplier-system#.E8.8E.B7.E5.8F.96.E6.9C.8D.E5.8A.A1.E6.8F.90.E4.BE.9B.E8.80.85.28.E5.8F.B8.E6.9C.BA.E3.80.81.E6.8E.A5.E9.80.81.E6.9C.BA.E4.BA.BA.E6.88.96.E5.AD.90.E4.BE.9B.E5.BA.94.E5.95.86.29.E5.88.97.E8.A1.A8
     * @param $orderid 订单ID
     * @param $status 状态值
     * @return mixed
     */
    public static function Http_getServicesList($order_id,$service_type){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['order_id'] = $order_id;
        $data['data']['service_type'] = $service_type;

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getServicesList');
        return $HttpReturn;
    }

    /**
     * 获取订单日志列表 hs20151228
     * http://wiki.baicheng.com/index.php/Supplier-system#.E8.8E.B7.E5.8F.96.E6.97.A5.E5.BF.97.E5.88.97.E8.A1.A8
     * @param $orderid 订单ID
     * @return mixed
     */
    public static function Http_getOrderLogList($order_id){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['order_id'] = $order_id;
        $data['data']['supplierOrDestination'] = 1;

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getLogList');
        return $HttpReturn;
    }

    /**
     * 获取订单日志列表 lyl20160418
     * http://wiki.baicheng.com/index.php/Supplier-system#.E8.8E.B7.E5.8F.96.E6.97.A5.E5.BF.97.E5.88.97.E8.A1.A8
     * @param $trade_id 主订单ID
     * @param $product_id 商品ID
     * @return mixed
     */
    public static function Http_getTourLogList($info){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['trade_id'] = $info['trade_id'];
        $data['data']['product_id'] = $info['product_id'];
        $data['data']['supplierOrDestination'] = 1;
        $data['data']['orderlogtype'] = $info['orderlogtype'];

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getTourLogList');
        return $HttpReturn;
    }

    /**
     * 写日志 lyl20160413
     * http://wiki.baicheng.com/index.php/Supplier-system#.E8.8E.B7.E5.8F.96.E6.97.A5.E5.BF.97.E5.88.97.E8.A1.A8
     * @param $tradeid 主订单ID
     * @param $parentNode 父节点ID
     * @param $recordContent 日志时间
     * @param $recordTime 日志时间
     * @param $operatNo 操作人编号
     * @param $isNo 是否在前端显示（目的地服务大厅）
     * @param $operatMan 操作人
     * @param $operatManFrom 所属1.供应商目的地 2目的地 3日游大厅（前端）
     * @param $type 类型，1接送机、2日游
     * @return mixed
     */
    public static function Http_Supp_addOperateRecordByDayTours($info){
        $data['data']['operatMan'] = Session::get('suppInfo.SUPPNAME')[0];  
        $data['data']['operatNo'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['productId'] = $info['product_id'];
        $data['data']['tradeId'] = $info['trade_id'];
        $data['data']['parentNode'] = $info['parentNode'];
        $data['data']['recordContent'] = $info['recordContent'];
        $data['data']['recordTime'] = date("Y/m/d H:i:s" , time());
        $data['data']['isNo'] = $info['isNo'];
        $data['data']['operatManFrom'] = $info['operatManFrom'];
        $data['data']['type'] = $info['type'];

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'Supp_addOperateRecordByDayTours');
        return $HttpReturn;
    }
    /**
     * 出单 hs20151231
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.89.A7.E8.A1.8C.E5.87.BA.E5.8D.95.E6.93.8D.E4.BD.9C
     * @param $info 订单ID
     * @return mixed
     */
    public static function Http_careatUpdateOutStatus($info){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['order_id'] = $info['order_id'];
        $data['data']['status'] = $info['status'];

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'updateOutStatus');
        return $HttpReturn;
    }
    /**
     * 出单(接送机几日游) lyl20160413
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.89.A7.E8.A1.8C.E6.8E.A5.E5.8D.95.E6.93.8D.E4.BD.9C_2
     * @param $info 订单ID
     * @return mixed
     */
    public static function Http_updateOutStatusPublic($info){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
         $data['data']['trade_id'] = $info['trade_id'];
         $data['data']['from_time'] = isset($info['from_time'])?$info['from_time']:'';
         $data['data']['to_time'] = isset($info['to_time'])?$info['to_time']:'';
        $data['data']['productId'] = $info['product_id'];
        $data['data']['status'] = $info['status'];
        $data['data']['remark'] = isset($info['remark'])?$info['remark']:'';

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'updateOutStatusPublic');
        return $HttpReturn;
    }
    /**
     * 执行订单状态修改操作 hs20160104
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.89.A7.E8.A1.8C.E8.AE.A2.E5.8D.95.E7.8A.B6.E6.80.81.E4.BF.AE.E6.94.B9.E6.93.8D.E4.BD.9C
     * @param $info 订单ID
     * @return mixed
     */
    public static function Http_updateOrderStatus($info){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['order_id'] = $info['order_id'];
        $data['data']['action_type'] = $info['action_type'];
        $data['data']['action_status'] = $info['action_status'];

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'updateOrderStatus');
        return $HttpReturn;
    }

    /**
     * 获取导游列表 lyl20160413
     * http://wiki.baicheng.com/index.php/Supplier-system#.E6.89.A7.E8.A1.8C.E8.AE.A2.E5.8D.95.E7.8A.B6.E6.80.81.E4.BF.AE.E6.94.B9.E6.93.8D.E4.BD.9C
     * @return mixed
     */
    public static function Http_getSupplierGuideList(){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['guide_id'] = '';

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'getSupplierGuideList');
        return $HttpReturn;
    }

    /**
     * 获取boss勾选项 lyl20160429
     * http://wiki.baicheng.com/index.php/%E6%97%A5%E6%B8%B8%E5%A4%A7%E5%8E%85#GetTravellerTourRadio_.E6.97.A5.E6.B8.B8.E8.8E.B7.E5.8F.96boss.E5.8B.BE.E9.80.89
     * @return mixed
     */
    public static function Http_GetTravellerTourRadio( $product_id ){
        $data['data']['product_id'] = $product_id;

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'GetTravellerTourRadio');
        return $HttpReturn;
    }

    /**
     * 修改单状态操作（日游） lyl20160505
     * http://wiki.baicheng.com/index.php/Supplier-system#.E4.BF.AE.E6.94.B9.E5.8D.95.E7.8A.B6.E6.80.81.E6.93.8D.E4.BD.9C.EF.BC.88.E6.97.A5.E6.B8.B8.EF.BC.89
     * @param $trade_id 主订单ID
     * @param $product_id 产品ID
     * @param $status 状态值
     * @return mixed
     */
    public static function Http_updateTourOrderStatus($info){
        $data['data']['supplier_code'] = Session::get('suppInfo.suppCode')[0];
        $data['data']['operator_id'] = Session::get('suppInfo.operator_id')[0];
        $data['data']['trade_id'] = $info['trade_id'];
        $data['data']['product_id'] = $info['product_id'];
        $data['data']['status'] = $info['status'];

        $HttpReturn = \BC\Tools\IOTool::HttpRequestWithParams('PC_H5_App','app',$data,'updateTourOrderStatus');
        return $HttpReturn;
    }


}
