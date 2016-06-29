<?php
/**
 * Created by PhpStorm.
 * User: wb-bj-dn-245
 * Date: 16/6/29
 * Time: 下午6:00
 */



// 1,定义两个异常类
class MyException extends \RuntimeException {

}

class ExitException extends \Exception {

}

class UploadException extends \Exception {
    public function __construct($code){
        $message = $this->codeToMessage($code);
        parent::__construct($message, $code);
    }

    private function codeToMessage($code){
        switch($code){
            case UPLOAD_ERR_INI_SIZE:
                $message = '上传文件超过服务端限制';
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = '上传文件超过客户端限制';
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = '上传文件不完整';
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = '没有上传文件';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = '没有上传临时目录';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = '写入磁盘失败';
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = '文件上传被扩展阻止';
                break;
            default:
                $message = '未知上传错误';
                break;
        }
        return $message;
    }
}


// 2.定义自定义默认异常处理函数
function exception_handler($e) {

    if(($e instanceof ExitException)){
        echo "exit:".$e->getMessage();
        die;
    }

    if(($e instanceof UploadException)){
        echo "upload:".$e->getMessage();
        die;
    }

    echo "Myexception: " , $e->getMessage(), "\n";
    die;
}



// 3. 设置默认的异常处理程序,无try...catch时会自动调用,调用后异常会中止!
set_exception_handler('exception_handler');


// 4.如果设置 try...catch ,catch不到的话才会走自定义exception_handler
try
{
//    throw new \Exception('汇付天下签名服务连接失败');
//    throw new ExitException('1svsdfvdfvdf ');
//    throw new \UploadException(1);
    throw new \MyException("dfdsvs");

}
catch(\ExitException $e){
    echo "捕获自定义的异常：".$e->getMessage();
    die;

}
//catch (\Exception $e){
//    echo "aaaa:".$e->getMessage();
//    die;
//}


//throw new Exception('1svsdfvdfvdf ');
//throw new ExitException('1svsdfvdfvdf ');
//throw new \UploadException(1);
//echo "No\n";

