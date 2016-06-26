<?php
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
App::error(
function (Exception $exception) {
    Log::error($exception->getMessage());
    $count = 0;
    if(Session::has('error_count')&&Session::get('error_count')){
        $count = Session::get('error_count');
    }else{
        $count = $count + 1;
        Session::put('error_count',$count);
    }
    if ($GLOBALS['env'] == 'online'&&$count>4) {
        Session::forget('error_count');
        $mobile_list = ['13811109684','18601243823','13260028364','18910556606','13717829239'];
        $content = $exception->getMessage()? '异常消息:' . $exception->getMessage():'系统内部错误' . ';';
        foreach ($mobile_list as $key => $val) {
            $result = \BC\Tools\SMS::Send(Request::fullUrl() . '报500错误;' .$content, $val);
        }
    }else{
        $count = $count + 1;
        Session::put('error_count',$count);
    }
    if ($GLOBALS['env'] == 'online') {
        return Response::view('shared.errors', ['code' => 500], 500);
    }
});

App::missing(
function (Exception $exception) {
    Log::error($exception->getMessage());
    $count = 0;
    if(Session::has('error_count')&&Session::get('error_count')){
        $count = Session::get('error_count');
    }else{
        $count = $count + 1;
        Session::put('error_count',$count);
    }
    if ($GLOBALS['env'] == 'online'&&$count>4) {
        Session::forget('error_count');
        $mobile_list = ['13811109684','18601243823','13260028364','18910556606','13717829239'];
        $content = $exception->getMessage()? '异常消息:' . $exception->getMessage():'找不到该地址' . ';';
        $content = Request::fullUrl() . '报404错误;'.$content ;
        //echo $content;exit();
        Log::error($content);
        /*foreach ($mobile_list as $key => $val) {
            $result = \BC\Tools\SMS::Send(Request::fullUrl() . '报404错误;' .$content, $val);
        }*/
    }else{
        $count = $count + 1;
        Session::put('error_count',$count);
    }
    if ($GLOBALS['env'] == 'online') {
        return Response::view('shared.errors', ['code' => 404], 404);
    }
});
