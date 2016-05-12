<?php


mb_internal_encoding("UTF-8");
$string = "0123456789";
$string = "零一二三四五六七八九";


$mystring = substr($string, 5,1);
echo $mystring;


$mystring = mb_substr($string,5,1);
echo $mystring;
