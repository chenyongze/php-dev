<?php
/**
 * 上传文件到BRS
 * User: ljs
 * Date: 2016/01/12
 */

namespace BC\Tools;

use Illuminate\Support\Facades\Config;
class UploadFile
{

    /**
     * 上传文件
     * @param $fileObj:文件对象
     * @param $fileclassify:文件分类  //[必填]文件分类ID：1:签证、2:同行资料、3:护照、4:护照头像、5:移动签证、6:电子签证、7:保险、8:其它、9:电子预审
     * @param $fileName:文件名
     */
    static public function  UploadOneFile($fileObj,$fileclassify,$fileName=''){
        //判断文件是否正常
        if($fileObj->getError() != 0){
            return ['code'=>-1,'msg'=>"获取文件信息失败！"];
        }
        //获取文件路径
        $filePath = $fileObj->getRealPath();
        //文件大小,字节数
        $size = $fileObj->getSize();
        if($size > 5*1024*1024){
            return ['code'=>-1,'msg'=>"上传文件不能超过5M！"];
        }
        //文件类型,比如:image/jpeg
        $mimetype = $fileObj->getMimeType();
        //获取文件后缀
        $extention  = $fileObj->getClientOriginalExtension();
        $extention = strtolower($extention);
        if($fileName == ''){
            //拼串文件名
            $fileName = time().rand(11111, 9999).'.'.$extention;
        }
        //获取文件流
        $stream = base64_encode(file_get_contents($filePath));
        return self::UploadFileToBrs($fileName,$stream,$fileclassify);
    }
    /**
     * @param $filename:文件名
     * @param $filestream:base64编码的文件流
     * @param $fileclassify:文件分类
     */
    static public function UploadFileToBrs($filename,$filestream,$fileclassify){
        $ready = array(
            'FileName'=>$filename,
            'FileStream'=>$filestream,
            'FileClassify'=>$fileclassify,
        );
        $uploadPostData = array(
            'json_params'=> json_encode($ready)
        );
        //print_r($uploadPostData);die;

        $uploadResult = @IOTool::httpRequest( Config::get('api.http.brs.savefile'), 'post', $uploadPostData );
        $arrayResult = json_decode($uploadResult,true);

        //$arrayResult['Msg'] = self::GetMsgByErrorCode( intval($arrayResult['ErrorType']));
        return $arrayResult;
    }
}
