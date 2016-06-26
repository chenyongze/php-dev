<?php

function ss($data=''){
    success($data);
    die;
}

//function dd($data=''){
//    var_dump($data);
//    die;
//}


/**
 * @param string $data
 */
function success($data=''){
    $res = array(
        'statusCode' => 0,      //0 ,请求成功  -1系统繁忙，此时请开发者稍候再试
        'success'  => true,
        'error'  => 0,
    );
    if(!empty($data)){
        $res['data'] = _toStr($data);
    }
    header('Content-type: text/json');
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die;
}


/**
 * @param $statusCode
 * @param $msg
 */
function fail($msg,$statusCode=''){
    $res = array(
        'statusCode' => $statusCode?:-1,
        'success'  => false,
        'error'  => $msg,
    );
    header('Content-type: text/json');
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    die();
}

/**
 * @param $arr
 * @return mixed
 */
function _toStr($arr){
    foreach($arr as $k => $v){
        if(is_array($v)){
            $arr[$k] = toStr($v);
        }else{
            $arr[$k] = (string)$v;
        }
    }
    return $arr;
}


/**
 * @param $url
 * @return mixed
 * @throws Exception
 */
function httpGet($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//禁止直接显示获取的内容 重要
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书下同
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //
    $output = curl_exec($ch); //获取
    if (!$output) {
        $error = curl_error($ch);
        $errno = curl_errno($ch);
        throw new \Exception($error, $errno);
    }
    curl_close($ch);
    return $output;
}


/**
 * @param $url
 * @param array $data
 * @return mixed
 * @throws Exception
 */
function httpPost($url,$data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    if (!$output) {
        $error = curl_error($ch);
        $errno = curl_errno($ch);
        throw new \Exception($error, $errno);
    }
    curl_close($ch);
    return $output;
}
