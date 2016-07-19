<?php
/**
 * Created by PhpStorm.
 * User: wb-bj-dn-245
 * Date: 16/7/19
 * Time: 上午10:46
 */

include 'phpqrcode/phpqrcode.php';

//第一个参数$text，就是上面代码里的URL网址参数，
//第二个参数$outfile默认为否，不生成文件，只将二维码图片返回，否则需要给出存放生成二维码图片的路径
//第三个参数$level默认为L，这个参数可传递的值分别是L(QR_ECLEVEL_L，7%)，M(QR_ECLEVEL_M，15%)，Q(QR_ECLEVEL_Q，25%)，H(QR_ECLEVEL_H，30%)。这个参数控制二维码容错率，不同的参数表示二维码可被覆盖的区域百分比。
//        利用二维维码的容错率，我们可以将头像放置在生成的二维码图片任何区域。
//第四个参数$size，控制生成图片的大小，默认为4
//第五个参数$margin，控制生成二维码的空白区域大小
//第六个参数$saveandprint，保存二维码图片并显示出来，$outfile必须传递图片路径。


$url = "http://www.baidu.com";
$dir = __DIR__.DIRECTORY_SEPARATOR."image".DIRECTORY_SEPARATOR;
$file_name = "qrcode.png";
$errorCorrectionLevel = "H";
$size = 8;
$margin = 3;

// 目录不存在
if(! file_exists($dir)) {
    mkdir($dir, 0777, TRUE);
    chmod($dir, 0777);
}
$file = $dir . DIRECTORY_SEPARATOR.$file_name;

// 输出
//QRcode::png($url, false ,$errorCorrectionLevel, $size, $margin);

// 输出并保存 (不好使 ...)
//QRcode::png($url, $file ,$errorCorrectionLevel, $size, $margin,TRUE);


if(file_exists($file)){

}else{
    // 保存
    QRcode::png($url, $file ,$errorCorrectionLevel, $size, $margin);
}


// 保存带logo的二维码
$logo = 'logo.png';
if($logo !== FALSE)
{
    $QR = imagecreatefromstring(file_get_contents($file));
    $logo = imagecreatefromstring(file_get_contents($logo));
    $QR_width = imagesx($QR);
    $QR_height = imagesy($QR);
    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);
    $logo_qr_width = $QR_width / 5;
    $scale = $logo_width / $logo_qr_width;
    $logo_qr_height = $logo_height / $scale;
    $from_width = ($QR_width - $logo_qr_width) / 2;
    imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
}
// 保存
imagepng($QR,$dir.'QR-logo.png');

// 输出
header('Content-Type: image/png');
imagepng($QR);