<?php
/**
 * Created by PhpStorm.
 * User: njz
 * Date: 15-2-10
 * Time: 下午7:05
 */

namespace BC\Tools;

/**
 * 公共枚举相关操作；
 * @package BC\Tools
 */
final class EnumTool {
    /**
     * 订单单项成本，同boss里的OrderSingleCost  njz20160413
     * @var array
     */
    public static $OrderSingleCost  = array(
        'ProductCost' => 1,//签证费(产品成本)
        'InsuranceCost' => 2,//保险费

        'AuthenticationCost' => 3,//认证费
        'ServiceCost' => 4,//服务费
        'DocumentCost' => 5,//文案费
        'TrafficCost' => 6,//交通费
        'PostCost' => 7,//运费
        'GiftPacks' => 8,//礼包
        'TempHousingPermit' =>9,//暂住证
        'UsaVisa_PhoneCard' => 10,//美签电话卡
        'HuaYuanVisa_ProcedureFee' => 11,//华远签证部手续费
        'CommissionFee' => 12,//佣金费
        'ThaiPhoneCard' => 13,//泰国电话卡
        'ProductTagCost' => 14,//产品标签成本
        'Other' => 0//其他
    );
    /**
     * 订单成本类型，同boss里的OrderCostType  njz20160413
     * @var array
     */
    public static $OrderCostType = array(
        'ProductCost' => 1,//签证费(产品成本)
        'InsuranceCost' => 2,//保险费

        'AuthenticationCost' => 3,//认证费
        'ServiceCost' => 4,//服务费
        'DocumentCost' => 5,//文案费
        'TrafficCost' => 6,//交通费
        'PostCost' => 7,//运费
        'GiftPacks' => 8,//礼包
        'TempHousingPermit' =>9,//暂住证
        'UsaVisa_PhoneCard' => 10,//美签电话卡
        'HuaYuanVisa_ProcedureFee' => 11,//华远签证部手续费
        'CommissionFee' => 12,//佣金费
        'ThaiPhoneCard' => 13,//泰国电话卡
        'ProductTagCost' => 14,//产品标签成本
        'Other' => 0//其他
    );
    /**
     * 收款状态枚举  njz20160108
     * @var array
     */
    public static $FinanceArStatus = array(
        '0' => '未收款',
        '1' => '已申请',
        '4' => '收款未收齐',
        '5' => '收款成功 ',
        '7' => '审核不通过 ',
        '8' => '担保收款'
    );
    /**
     * 财务：发票状态枚举 njz20160108
     * @var array
     */
    public static $InvoiceStatus = array(
        '0' => '新建',
        '1' => '申请',
        '2' => '发票已开',
        '3' => '发票作废 ',
        '4' => '已取消 ',
    );

    /**
     * 签证出签形式  njz20160108
     * @var array
     */
    public static $VisaOutType = array(
        1=>'纸质',
        2=>'电子',
    );
    //签证工作流状态
    public static $VisaWorkFlowStatus = array(
        0=>'未开始',
        1=>'进行中',
        2=>'已完成',
        9=>'异常中止',
    );
    /**
     * 签证返还方式  njz20160108
     *
     * @var array
     */
    public static $VisaGainType = array(
        1=>'百程自取',
        2=>'快递',
        3=>'邮件（电子签证）',
        10=>'快递到付',
        11=>'使馆自取'
    );
    /**
     * 签证返还方式  lq20160121
     *
     * @var array
     */
    public static $VisaGainType1 = array(
        1=>'客户自取',
        2=>'佰程代取'
    );
    /**
     * 签证收件类型收取资料方式 njz20160108
     * @var array
     */
    public static $VisaReceviceType = array(
        1=>'快递',
        2=>'预审',
        3=>'转录入',
        4=>'上门',
        5=>'快递破损',
        6=>'其它'
    );

    /**
     * 签证出签结果：入境次数
     * @var array
     */
    public static $RuJingCiShu = array(
        '1' => '1次',
        '2' => '2次',
        '3' => '1年多次',
        '4' => '10年多次',
    );
    /**
     * 单个客人出签结果Oms_OrderVisaSendResult.Result njz20160114 1出签 2拒签 0未知
     * @var array
     */
    public static $VisaResults = array(
        '1' => '出签',
        '2' => '拒签',
        '0' => '未知',//未知
    );
    /**
     * 单个签证订单的出签结果Order_Visa_VerifyInfo.VisaResult  njz20160114 1出签 2拒签 3部分拒签 0未知
     * @var array
     */
    public static $VisaOrderResults = array(
        '1' => '出签',
        '2' => '拒签',
        '3' => '部分拒签',
        '0' => '未知',//未知
    );
    /**
     * 签证订单工作流节点枚举  njz20160108
     * @var array
     */
    public static $VisaWFNodes = array(
        '1' => '录入',
        '2' => '审核',
        '3' => '统筹',
        '4' => '制作',
        '5' => '送签',
        '6' => '出签 ',
    );
    /**
     * 签证预约状态枚举  njz20160108
     * @var array
     */
    public static $VisaEngagementStatus = array(
        '0' => '未预约',
        '1' => '预约申请',
        '2' => '预约确认',
        '3' => '预约更改申请 ',
        '4' => '预约更改确认',
        '5' => '预约完成',
        '-1' => '取消预约'
    );
    /**
     * 签证加急状态枚举  njz20160108
     * @var array
     */
    public static $VisaUrgentStatus = array(
        '0' => '不加急',
        '1' => '加急一天',
        '2' => '加急两天',
        '3' => '加急三天 ',
        '4' => '加急四天',
        '5' => '加急五天',
        '6' => '加急六天',
        '7' => '绿色通道',
        '100' => '加急',
    );
    #region 签证子订单相关状态 枚举值
    /**
     * 签证子订单状态 njz20151223
     * @var array
     */
    public static $VisaOrderStatus = array(
        '1' => '预订单',
        '2'=>'预订单分配',
        '3' => '订单关闭',
        '4'=>'订单分配',
        '5' => '订单确认',
        '6' => 'OP审核',
        '7' => '送签',
        '8' => '办理结束',
        '9' => '订单完成',
        '10'=>'订单取消中',
        '11'=>'出票',
        '12' => '订单',
        '13' => '资料审核成功',
        '14' => '订单取消完成',
        '15' => '资料审核失败',
        '16'=>'预订单取消',
        '17'=>'消签',
        '18'=>'预订单支付完成',
        '19'=>'预订单部分支付完成',
    );
    /**
     * 签证子订单状态之预约状态 njz20151223
     * @var array
     */
    public static $VisaOrderStatus_YuYue = array(
        '1' => '未预约',
        '2' => '预约申请',
        '3' => '确认预约',
    );
    #region 签证类型 枚举值

    public static $VisaType = array(
        '0' => '全部',
        '1'=>'泰马',
        '2' => '大签证',
        '3'=>'外包签证',
        '4' => '越柬菲印老尼',
    );
    #endregion
    /**
     * 签证子订单状态之送签状态 njz20151223
     * @var array
     */
    public static $VisaOrderStatus_SongQian = array(
        '1' => '待送签',
        '2' => '送签',
    );
    /**
     * 签证子订单状态之出签状态 njz20151223
     * @var array
     */
    public static $VisaOrderStatus_ChuQian = array(
        '1' => '待出签',
        '2' => '办理结束',
    );
    #endregion

    #region 保险订单状态 枚举值

    public static $InsuranceOrderStatus = array(
        '1' => '保险已出',
        '2'=>'保险已退',
        '3' => '保险申请',
        '4'=>'保险变更申请',
        '5' => '后补保险申请',
        '6' => '保险出保失败',
    );
    #endregion

    /**
     * @var array 出发城市 njz20150217
     */
    public static $DepartCity = array(
        '0' => '全部',
        '1' => '上海',
        '2' => '北京',
        '3' => '广州',
        '4' => '香港',
        '5' => '天津',
        '6' => '成都',
        '7' => '昆明',
        '8' => '南京',
        '9' => '宁波',
        '10' => '沈阳',
        '11' => '武汉',
        '12' => '长沙',
        '13' => '杭州',
        '14' => '乌鲁木齐',
        '31' => '深圳',
        '32' => '澳门',
        '33' => '重庆',
        '38' => '厦门',
        '39' => '西安'
    );

    /**
     * 订单类型，即产品类型 njz20160109
     * @var array
     */
    public static $OrderType = array(
        '1' => '签证',
        '2'=>'跟团游',
        '3' => '自由行',
        '4'=>'邮轮',
        '5' => '交通方案',
        '6' => '酒店',
        '7' => '机票',
        '8' => '附加产品',
        '20' => '巴士游',
        '21' => '保险',
        '22' => '交通服务',
        '25' => '其他',
        '27' => '特色服务',
        '29' => '景点门票',
        '36' => '青年旅社卡',
        '37' => '香港驾照',
        '46'=>'其他',
        '47'=>'私属定制',
        '50'=>'一日/半日游',
        '51' => '单项服务',
        '53' => '国际租车',
        '54' => '游轮游船',
        '55' => '当地游览',
        '56' => '机场接送',
        '58' => '演出表演',
        '59' => '境外通讯',
        '60' => '导游服务',
        '61' => '特惠购物',
        '62' => '特色餐饮',
        '63' => '体育赛事',
        '64' => '旅游装备',
        '66' => '度假产品',
        '70' => '购物',
        '71' => '现金券',
        '72' => '礼品券',
        '73' => '折扣券',
    );

    /**
     * 分公司  njz20160109
     * @var array
     */
    public static $Com_Branch = array(
        '2' => '佰程北京总公司',
        '15' => '佰程上海分公司',
        '16' => '佰程广州分公司',
        '17' => '佰程沈阳分公司',
        '18' => '佰程成都分公司',
        '19' => '百程深圳分公司',
        '20' => '百程武汉分公司',
    );
    /**
     * 分公司简写  ljs20160115
     * @var array
     */
    public static $Com_Branch_Short = array(
        '2' => 'BJ',
        '15' => 'SH',
        '16' => 'GZ',
        '17' => 'SY',
        '18' => 'CD',
    );
    /**
     * 内部服务公司 njz20160108
     * @var array
     */
    public static $InternalServiceCom = array(
        '2' => '佰程北京总公司',
        '15' => '佰程上海分公司',
        '16' => '佰程广州分公司',
        '17' => '佰程沈阳分公司',
        '18' => '佰程成都分公司',
        '19' => '百程深圳分公司',
        '20' => '百程武汉分公司',
    );
    /**
     * @var array 资料类别
     */
    public static $CustType = array(
        1=>'成人',
        2=>'老人',
        3=>'儿童',
        4=>'0-12岁儿童',
        5=>'婴儿'
    );

    /**
     * @var array 人群类型
     */
    public static $CustSource = array(
        //0=>'所有人员',
        1=>'在职人员',
        2=>'自由职业者',
        3=>'退休人员',
        4=>'学生',
        5=>'学龄前儿童'
    );
    /**
     * @var array 预约面试办签人上传文件类型
     */
    public static $OrderVisaMakeMatetialFiletype = array(
        1=>'使馆版信息表',
        2=>'使馆版确信页',
        3=>'使馆版预约页',
        4=>'文件清单',
    );
    /**
     * @var array 客户来源类型
     */
    public static $CustSourceEnum = array(
        1=>'C',  //直客,
        2=>'A', //同行
        3=>'TB', //淘宝
    );
    /**
     * @var array 客户来源类型
     */
    public static $OrderCustSourceEnum = array(
        1=>'直客',  //直客,
        2=>'同行', //同行
        3=>'淘宝', //淘宝
    );
    /**
     * @var array 签证大厅里的资料预审状态
     */
    public static $preAuditUploadStatus = array(
        1 =>'已上传',
        2=>'合格',
        3=>'不合格',
        4=>'已放弃',
        5=>'不合格再次上传',
        6=>'未上传'
    );
    /**
     * @var array 资料预审状态
     */
    public static $preAuditStatus = array(
        0 =>'待上传',
        1=>'待审核',
        2=>'正审核',
        3=>'未通过',
        4=>'审核完成'
    );
    public static $clientAuditResult =array(
        1 => '合格',
        2 =>'不合格',
        3 => '客户自备',
        4 => '客户不提供'
    );
    /**
     * @var array 保险与被保险人关系
     */
    public static $insuranceRelation = array(
        1 =>'本人',
        2=>'配偶',
        3=>'父母',
        4=>'子女',
        5=>'其他'
    );
    /**
     * @var array 保险被保人类型
     */
    public static $insuranceInInsuredFlag = array(
        0 =>'持有人',
        1=>'持有人&被保险人',
        2=>'被保人',
    );
    /**
     * @var array 保险人群性别
     */
    public static $insuranceSex = array(
        0=>'女',
        1=>'男',
    );
    /**
     * @var array 保险证件类型
     */
    public static $insuranceCartype = array(
        1=>'护照',
        2=>'身份证',
        3=>'军官证',
        5=>'台胞证',
        6=>'港澳台通行证',
        9=>'其他证件',
    );
    /**
     * @var array 保险证件类型
     */
    public static $insuranceCartype_pingan = array(
        1=>'身份证',
        2=>'护照',
        3=>'军官证',
        5=>'台胞证',
        6=>'港澳台通行证',
        9=>'其他证件',
    );
    /**
     * @var array 订单财务数据固化的预付款类型
     */
    public static $orderPaymentType = array(
        0=>'未付款',
        1=>'已付款',
        2=>'部分付款',
    );
    /**
     * @var array 订单财务数据固化的预付款状态
     */
    public static $orderPaymentStatus = array(
        0=>'新建',
        1=>'申请付款',
        2=>'审核通过',
        3=>'审核不通过',
        4=>'重新申请付款',
        5=>'确认付款',
        6=>'取消付款',
    );
    /**
     * @var array 订单财务数据固化的应付款类型
     */
    public static $orderAplistType = array(
        0=>'未付款',
        1=>'已付款',
        2=>'部分付款',
    );
    /**
     * @var array 业务应付款单状态
     */
    public static $orderPayableStatus = array(
        0=>'新建',
        1=>'申请付款',
        2=>'审核通过',
        3=>'审核不通过',
        4=>'重新申请付款',
        5=>'确认付款',
        6=>'取消付款',
    );
    /**
     * @var array 订单财务发票的状态
     */
    public static $orderArInvoiceStatus = array(
        0=>'新建',
        1=>'已申请',
        2=>'已审核',
        3=>'未通过',
        4=>'取消',
    );
    /**
     * @var array 订单财务成本单的状态
     */
    public static $orderCostSheetStatus = array(
        0=>'新建',
        1=>'申请',
        2=>'审核成功',
        3=>'审核未通过',
    );
    /**
     * @var array 订单财务更改单类型
     */
    public static $orderChangeOrderType = array(
        1=>'更改订单金额',
        2=>'更改订单成本',
        3=>'更改供应商',
    );
    /**
     * @var array 订单财务更改单状态
     */
    public static $orderChangeOrderStatus = array(
        1=>'申请',
        2=>'审核通过',
        3=>'审核不通过',
    );
    /**
     * @var array 订单财务退款单状态
     */
    public static $orderRefundStatus = array(
        0=>'未申请退款',
        1=>'退款申请',
        2=>'审核作废',
        3=>'全额退款成功',
        4=>'部分退款成功',
        5=>'审核通过',
    );
    /**
     * @var array 订单财务退款明细单状态
     */
    public static $orderRefundLogStatus = array(
        1=>'退款申请',
        2=>'审核通过',
        3=>'审核失败',
        4=>'退款成功',
        5=>'Op审核通过',
        6=>'Op审核不通过',
        7=>'部门经理审核通过',
        8=>'部门经理审核不通过',
    );
    /**
     * @var array 订单财务退款操作类型
     */
    public static $orderRefundOpType = array(
        1=>'普通退款',
        2=>'拒签退款',
    );
    /**
     * @var array 订单财务发票客户类型
     */
    public static $orderArInvoiceCustomerType = array(
        1=>'个人',
        2=>'公司',
    );
    /**
     * @var array 订单财务发票开票项目
     */
    public static $orderArInvoiceType = array(
        1=>'签证费',
        2=>'机票费',
        3=>'酒店费',
        4=>'团费',
        5=>'境外餐费',
        6=>'领队小费',
        7=>'认证费',
        8=>'交通费',
        9=>'客户礼品费',
        10=>'其他',
        11=>'租车费',
        12=>'接送机费',
        13=>'景点门票费',
        14=>'日游费',
        15=>'旅游装备',
        16=>'保险费',
        17=>'邀请费',
        18=>'加急费',
        19=>'服务费',
    );
    /**
     * @var array 订单支付方式
     */
    public static $orderPayType = array(
        1=>'现金',
        2=>'快钱_信用卡支付',
        3=>'支付宝',
        4=>'快钱_普通用户',
        5=>'转账',
        6=>'汇款',
        7=>'支票',
        8=>'环讯信用卡支付',
        9=>'快钱（Qunar）',
        10=>'网上银行',
        11=>'刷卡',
        12=>'民生银行支付',
        13=>'易宝支付',
        14=>'刷卡（招商银行白金卡）',
        15=>'分公司确认单',
        19=>'华远分公司确认-武汉',
        23=>'时代环球公司确认',
        24=>'支付宝(2%)',
        25=>'现金券支付',
        26=>'聚划算',
        27=>'支付宝（团购1%）',
        28=>'民生信用卡',
        29=>'市场部支付',
        30=>'华远台湾帐户',
        31=>'华远挂帐',
        32=>'民生差旅卡',
        33=>'快钱iOS移动端支付',
        34=>'（去哪儿)支付',
        35=>'京东（小签证1%）',
        36=>'京东支付',
        37=>'当当（签证3%）',
        38=>'支付宝手机客户端支付',
        40=>'同程网',
        41=>'苏宁（小签2%）',
        42=>'苏宁（大签5%）',
        43=>'苏宁（度假3%）',
        44=>'为为网',
        45=>'五星汇',
        46=>'支付宝_网站',
        47=>'银联（信用卡）',
        48=>'银联（借记卡）',
        49=>'银联（移动支付）',
        50=>'腾讯旅游',
        51=>'现金-美元',
        52=>'活动码',
        53=>'刷卡(非美元，非人民币)',
        54=>'刷卡(美元或人民币)',
        55=>'蚂蜂窝活动代收',
        56=>'招行信用卡',
        57=>'携程支付',
        58=>'淘在路上',
        59=>'途牛代收',
        60=>'穷游825爆款',
        61=>'CarRental支付',
        62=>'微信公众号支付',
        63=>'百度轻应用支付',
        64=>'唯品会支付',
        65=>'蚂蜂窝对接支付',
        66=>'美团对接支付',
        67=>'大众点评代收',
        68=>'微信App支付',
        69=>'同程代收',
        70=>'穷游支付宝支付',
        71=>'游谱网支付',
        72=>'应收款',
        73=>'海南航空支付',
        74=>'百度聚合',
        75=>'已收款',
    );

    /**
     * @var array 接送服务类型
     */
    public static $serviceType = array(
        ''=>'',
        0=>'自行往返',
        1=>'只需接',
        2=>'只需送',
        3=>'需要接送',
        4=>'需要接送'
    );
    /**
     * @var array 培训方式类型
     */
    public static $trainType = array(
        1=>'上门',
        2=>'电话',
        3=>'视频',
        4=>'无需培训',
    );

    /**
     * @var array 签证订单电子预审状态
     */
        public static $HearingType = array(
        0=>'待上传',
        1=>'待审核',
        2=>'正审核',
        3=>'未通过',
        4=>'审核完成',
    );

    /**
     * @var array 签证订单电子预审上传平台
     */
    public static $HearingUploadFrom = array(
        1=>'PC',
        2=>'H5',
        3=>'IOS',
        4=>'Andorid',
    );
}
