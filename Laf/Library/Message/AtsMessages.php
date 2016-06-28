<?php
class AtsMessages
{
	const UNDEFINDED_ERROR								= -1;
	
	//success
	const SUCCESS										= 100000;
	
	//failure
	const PARAMS_INVALID 								= 10150001;
	const DATA_FIELD_NOT_FOUND 							= 10150002;
	const DATA_FIELD_FORMAT_ERROR						= 10150003;
	const TRACE_ID_NOT_FOUND 							= 10150004;
	const TRACE_ID_FORMAT_ERROR							= 10150005;
	const APP_TYPE_ERROR								= 10150006;
	const CHANNEL_ID_NOT_FOUND							= 10150007;
	const CHANNEL_ID_FORMAT_ERROR						= 10150008;
	const PAY_SOURCE_NOT_FOUND							= 10150009;
	const PAY_SOURCE_FORMAT_ERROR						= 10150010;
	const APP_TYPE_NOT_FOUND							= 10150011;
	const APP_TYPE_FORMAT_ERROR							= 10150012;
	const CARD_TYPE_NOT_FOUND							= 10150013;
	const CARD_TYPE_FORMAT_ERROR						= 10150014;
	const OUT_ORDER_ID_NOT_FOUND						= 10150015;
	const OUT_ORDER_ID_FORMAT_ERROR						= 10150016;
	const SYNC_URL_NOT_FOUND							= 10150017;
	const SYNC_URL_FORMAT_ERROR							= 10150018;
	const TRADE_IP_NOT_FOUND							= 10150019;
	const TRADE_IP_FORMAT_ERROR							= 10150020;
	const MERGE_INFO_NOT_FOUND							= 10150021;
	const MERGE_INFO_FORMAT_ERROR						= 10150022;
	const AGENT_ID_NOT_FOUND							= 10150023;
	const AGENT_ID_FORMAT_ERROR							= 10150024;
	const SPLIT_MODE_NOT_FOUND							= 10150025;
	const SPLIT_MODE_FORMAT_ERROR						= 10150026;
	const AMOUNT_NOT_FOUND								= 10150027;
	const AMOUNT_FORMAT_FOUND							= 10150028;
	const SUB_OUT_ORDER_ID_NOT_FOUND					= 10150029;
	const SUB_OUT_ORDER_ID_FORMAT_ERROR					= 10150030;
	const ASYNC_URL_NOT_FOUND							= 10150031;
	const ASYNC_URL_FORMAT_ERROR						= 10150032;
	const SUBJECT_NOT_FOUND								= 10150033;
	const SUBJECT_FORMAT_ERROR							= 10150034;
	const BODY_NOT_FOUND								= 10150035;
	const BODY_FORMAT_ERROR								= 10150036;
	const ACCOUNT_INFO_NOT_FOUND						= 10150037;
	const ACCOUNT_INFO_ABNORMAL							= 10150038;
	const IS_MERGE_TRADE_NOT_FOUND						= 10150039;
	const IS_MERGE_TRADE_FORMAT_ERROR					= 10150040;
	const ALIPAY_GET_TOKEN_ERROR						= 10150041;
	const ALIPAY_CERTIFICATE_FILE_NOT_FOUND				= 10150042;
	const ALIPAY_CERTIFICATE_FILE_FORMAT_ERROR  		= 10150043;
	const ALIPAY_SAFE_PAY_SIGN_FAILURE					= 10150044;
	const ALIPAY_SAFE_CALLBAKK_DATA_ERROR				= 10150045;
	const NOT_ALIPAY_CALLBACK_REQUEST					= 10150046;
	const CURL_ERROR									= 10150047;
	const NOT_VALID_ALIPAY_CALLBACK_REQUEST				= 10150048;
	const ALIPAY_SAFE_CALLBACK_SING_TYPE_ERROR			= 10150049;
	const ALIPAY_SAFE_CALLBACK_SIGN_NOT_MATCH   		= 10150050;
	const ALIPAY_PUBLIC_KEY_NOT_FOUND					= 10150051;
	const ALIPAY_PUBLIC_KEY_FORMAT_ERROR 				= 10150052;
	const ALIPAY_SAFE_CALLBACK_SIGN_ERROR 				= 10150053;
	const ALIPAY_SAFE_CALLBACK_TRADE_STATUS_ERROR		= 10150054;
	const PC_TRADE_NO_NOT_FOUND							= 10150055;
	const PC_TRADE_NO_FORMAT_ERROR						= 10150056;
	const REFUND_AMOUNT_NOT_FOUND						= 10150057;
	const REFUND_AMOUNT_FORMAT_ERROR					= 10150058;
	const CREATE_TRADE_FAILURE							= 10150059;
	const DBLIBRARY_ERROR								= 10150060;
	const TRADE_INFO_NOT_FOUND							= 10150061;
	const TRADE_FAILURE_NOT_REFUND						= 10150062;
	const REFUND_AMOUNT_MORE_THAN_AMOUNT				= 10150063;
	const REFUND_REQUEST_RETURN_RESULT_ERROR			= 10150064;
	const REFUND_FAILURE								= 10150065;
	const REFUND_PROCESSING								= 10150066;
	const REFUND_REQUEST_INFO_ERROR						= 10150067;
	const REFUND_INFO_INSERT_DATABASE_FAILURE			= 10150068;
	const ALIPAY_REFUND_CALLBACK_DATA_ERROR				= 10150069;
	const ALIPAY_REFUND_CALLBACK_SING_TYPE_ERROR		= 10150070;
	const ALIPAY_REFUND_SUCCESS_NUM_ERROR				= 10150071;
	const ALIPAY_REFUND_NOTIFY_TIME_ERROR				= 10150072;
	const ALIPAY_REFUND_NOTIFY_TYPE_ERROR				= 10150073;
	const ALIPAY_REFUND_SING_ERROR						= 10150074;
	const ALIPAY_REFUND_BATCH_NO_ERROR					= 10150075;
	const ALIPAY_REFUND_RESULT_DETAILS					= 10150076;
	const ALIPAY_REFUND_CALLBACK_SIGN_NOT_MATCH			= 10150077;
	const REFUND_INFO_UPDATE_DATABASE_FAILURE			= 10150078;
	const ALIPAY_REFUND_CALLBACK_REQUEST_NOT_FOUND		= 10150079;
	const ALIPAY_REFUND_NOTICE_DATA_INSERT_FAILURE		= 10150080;
	const ALIPAY_REFUND_COMPLETE_OR_PROCESSING			= 10150081;
	const ALIPAY_WEB_CALLBACK_NOTIFY_TIME_ERROR 		= 10150082;
	const ALIPAY_WEB_CALLBACK_NOTIFY_TYPE_ERROR			= 10150083;
	const ALIPAY_WEB_CALLBACK_NOTIFY_ID_ERROR			= 10150084;
	const ALIPAY_WEB_CALLBACK_SIGN_TYPE_ERROR			= 10150085;
	const ALIPAY_WEB_CALLBACK_SIGN_ERROR				= 10150086;
	const ALIPAY_WEB_CALLBACK_SIGN_NOT_MATCH			= 10150087;
	const ALIPAY_SAFE_CALLBACK_NOTIFY_TIME_ERROR 		= 10150088;
	const ALIPAY_SAFE_CALLBACK_NOTIFY_TYPE_ERROR		= 10150089;
	const ALIPAY_SAFE_CALLBACK_OUT_TRADE_NO_ERROR		= 10150090;
	const ALIPAY_SAFE_CALLBACK_TRADES_NOT_FOUND			= 10150091;
	const ALIPAY_WEB_CALLBACK_TRADES_NOT_FOUND			= 10150092;
	const ALIPAY_REFUND_ORDER_REFUND_ID_NOT_FOUND		= 10150093;
	const ALIPAY_REFUND_ORDER_REFUND_ID_FORMAT_ERROR	= 10150094;
	const ALIPAY_REFUND_INFO_NOT_FOUND					= 10150095;
	const CHANNEL_ID_VALUE_ERROR						= 10150096;
	const PAY_SOURCE_VALUE_ERROR						= 10150097;
	const REFUND_OFFLINE_USERNAME_NOT_FOUND				= 10150098;
	const REFUND_OFFLINE_USERNAME_NO_COMPETENCE			= 10150099;
	const REFUND_OFFLINE_PASSWORD_NOT_FOUND				= 10150100;
	
	const CARDNO_NOT_FOUND                              = 10150101;
	const CVV2_NOT_FOUND                                = 10150102;
	const VALIDDATE_NOT_FOUND                           = 10150103;
	const CARDHOLDERNAME_NOT_FOUND                      = 10150104;
	const CARDHOLDERID_NOT_FOUND                        = 10150105;
	const IDTYPE_NOT_FOUND                              = 10150106;
	const CUSTOMERID_NOT_FOUND                          = 10150107;
	const PHONENO_NOT_FOUND                             = 10150108;
	const PAY_ELEMENT_NOT_FOUND                         = 10150109;
	const GET_VERIFY_CODE_FAILD                         = 10150110;
	const WEB_CALLBACK_SIGN_NOT_MATCH			        = 10150111;
	const WEB_CALLBACK_TRADES_NOT_FOUND			        = 10150112;
	const REFUND_CALLBACK_DATA_ERROR				    = 10150113;
	const REFUND_INFO_NOT_FOUND					        = 10150114;
	const TRADE_NO_NOT_FOUND                            = 10150115;
	const FUNCTION_NOT_SUPPORT                          = 10150116;
	const REQUEST_ABNORMAL                              = 10150117;
	const BATCH_NO_NOT_FOUND                            = 10150118;
	const REFUND_TRADE_NO_NOT_FOUND                     = 10150119;
	const NOTIFY_DATA_NO_NOT_FOUND                      = 10150120;
	const CHECK_SIGN_FAILED                             = 10150121;
	const VERIFY_URL_NOT_FOUND                          = 10150122;
	const CAN_NOT_PAY                                   = 10150123;
	const ORDER_URL_NOT_FOUND                           = 10150124;
	const SOURCE_NOT_FOUND                              = 10150125;
    const QIHUHJ_BACKCODE_NOT_FOUND                     = 10150126;
    const QIHUHJ_BACKCODE_PAY_PENDING                   = 10150127;
	
	private static $message = array(
		-1		 => '未定义错误',	

		100000	 => '成功',
			
		10150001 => '参数不合法',
		10150002 => 'data参数字段未发现',
		10150003 => 'data参数格式错误',
		10150004 => 'trace_id未发现',
		10150005 => 'trace_id格式错误',
		10150006 => 'app_type字段值错误',
		10150007 => 'channel_id未发现',
		10150008 => 'channel_id参数格式错误',
		10150009 => 'pay_source未发现',
		10150010 => 'pay_source参数格式错误',
		10150011 => 'app_type未发现',
		10150012 => 'app_type参数格式错误',
		10150013 => 'card_type未发现',
		10150014 => 'card_type参数格式错误',
		10150015 => 'out_order_id未发现',
		10150016 => 'out_order_id参数格式错误',
		10150017 => 'sync_url未发现',
		10150018 => 'sync_url格式错误',
		10150019 => 'trade_ip未发现',
		10150020 => 'trade_ip参数格式错误',
		10150021 => 'merge_info未发现',
		10150022 => 'merge_info参数格式错误',
		10150023 => 'agent_id未发现',
		10150024 => 'agent_id参数格式错误',
		10150025 => 'split_mode未发现',
		10150026 => 'split_mode参数格式错误',
		10150027 => 'amount未发现',
		10150028 => 'amount参数格式错',
		10150029 => 'sub_out_order_id未发现',
		10150030 => 'sub_out_order_id参数格式错误',
		10150031 => 'async_url未发现',
		10150032 => 'async_url参数格式错误',
		10150033 => 'subject未发现',
		10150034 => 'subject参数格式错误',
		10150035 => 'body未发现',
		10150036 => 'body参数格式错误',
		10150037 => '供应商户信息未发现',
		10150038 => '供应商户信息异常',
		10150039 => 'is_merge_trade未发现',
		10150040 => 'is_merge_trade参数格式错误',
		10150041 => 'wap支付获得token失败',
		10150042 => '支付中心支付证书文件丢失',
		10150043 => '支付中心证书文件异常',
		10150044 => '安全支付生成签名失败',
		10150045 => '安全支付回调参数异常',
		10150046 => '非支付宝安全支付回调请求',
		10150047 => 'Curl错误',
		10150048 => '非有效的支付宝安全支付回调请求',
		10150049 => '安全支付回调请求的sign type参数异常',
		10150050 => '安全支付回调请求sign验证不匹配',
		10150051 => '支付宝公钥文件未发现',
		10150052 => '支付宝公钥文件异常',
		10150053 => '支付宝安全支付回调sign参数异常',
		10150054 => '支付宝安全支付回调交易状态异常',
		10150055 => '退款交易号pc_trade_no未发现',
		10150056 => '退关交易号pc_trade_no参数格式错误',
		10150057 => '退款金额refund_amount未发现',
		10150058 => '退款金额refund_amount参数格式异常',
		10150059 => '创建订单交易失败',
		10150060 => 'DBLibrary错误',
		10150061 => '交易信息未发现',
		10150062 => '交易未成功无法退款',
		10150063 => '退款金额不能大于可退金额',
		10150064 => '退款请求响应异常',
		10150065 => '退款失败',
		10150066 => '退款处理中',
		10150067 => '退款请求参数异常',
		10150068 => '退款请求入库失败',
		10150069 => '支付宝退款异步回调参数异常',
		10150070 => '支付宝退款回调请求的sign type参数异常',
		10150071 => '支付宝退款回调success_num参数异常',
		10150072 => '支付宝退款回调notify_time参数异常',
		10150073 => '支付宝退款回调notify_type参数异常',
		10150074 => '支付宝退款回调sign参数异常',
		10150075 => '支付宝退款回调batch_no参数异常',
		10150076 => '支付宝退款回调result_details参数异常',
		10150077 => '退款回调请求sign验证不匹配',
		10150078 => '退款请求更新数据库失败',
		10150079 => '退款回调中的batch_no在退款数据中未发现',
		10150080 => '退款通知数据插入数据库失败',
		10150081 => '订单退款已完成或者正在受理中无需重复提交',
		10150082 => '支付宝web回调notify_time参数异常',
		10150083 => '支付宝web回调notify_type参数异常',
		10150084 => '支付宝web回调notify_id参数异常',
		10150085 => '支付宝web回调sign_type参数异常',
		10150086 => '支付宝web回调sign参数异常',
		10150087 => '支付宝web回调sign验证不匹配',
		10150088 => '支付宝安全支付回调的notify_time参数异常',
		10150089 => '支付宝安全支付回调的notify_type参数异常',
		10150090 => '支付宝安全支付回调的out_trade_no参数异常',
		10150091 => '支付宝安全支付回调时原交易信息未发现',
		10150092 =>	'交易信息未发现',
		10150093 => '款请求order_refund_id参数未发现',
		10150094 => '退款请求order_refund_id参数格式错误',
		10150095 => '支付宝退款信息未发现',
		10150096 => 'channel_id字段值错误',
		10150097 => 'pay_source字段值错误',
		10150098 => 'username未发现',
		10150099 => '此用户没有操作权限',
		10150100 => 'password未发现',	
		
		10150101 => '卡号未发现',
		10150102 => 'cvv2未发现',
		10150103 => '有效期缺失',
		10150104 => '持卡人姓名缺失',
		10150105 => '持卡人证件号码缺失',
		10150106 => '持卡人证件类型缺失',
		10150107 => '用户表示缺失',
		10150108 => '电话号码缺失',
		10150109 => '支付要素缺失',
		10150110 => '获取验证码失败',
		10150111 => '支付回调验签不通过',
		10150112 =>	'支付回调时原交易信息未发现',
		10150113 => '退款异步回调参数异常',
		10150114 => '退款信息未发现',
		10150115 => '第三方交易流水未发现',
		10150116 => '暂不支持此功能',
		10150117 => '请求异常,没有响应',
		10150118 => '退款批次号未发现',
		10150119 => '退款交易未发现',
		10150120 => '支付宝异步通知notify_data未发现',
		10150121 => '验证签名失败',
		10150122 => '校验订单地址未发现',
		10150123 => '业务系统返回不能支付',
		10150124 => '订单详情页没发现',
		10150125 => '订单来源不正确',
        10150126 => '奇虎360生活助手支付字符串解错误',
        10150127 => 'success',

			
	);
	
	public static function getMessage($id)
	{
		return self::$message[$id];
	}
}