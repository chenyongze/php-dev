# **phpQRcode**

## 下载官网提供的类库后，只需要使用phpqrcode.php就可以生成二维码了，当然您的PHP环境必须开启支持GD2。



- **[ 代码如下 ]**:

```php
public static function png($text, $outfile=false, $level=QR_ECLEVEL_L, $size=3, $margin=4, $saveandprint=false)    
{   
    $enc = QRencode::factory($level, $size, $margin);   
    return $enc->encodePNG($text, $outfile, $saveandprint=false);   
}  

```