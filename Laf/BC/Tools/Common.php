<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2015/3/3
 * Time: 15:43
 */

namespace BC\Tools;


class Common
{

    /**
     * @todo 公用分页
     *
     * @author Justin.W
     * @param string $searchSuffix url后缀
     * @param int $totalPage 页面总数
     * @param int $currentPage 当前页面
     * @return string
     */
    public static function paging($searchSuffix, $totalPage, $currentPage)
    {
        $pagingStr = '';
        if ((empty($totalPage) && empty($currentPage))||$totalPage<=1)
        {
            return $pagingStr;
        }
        if ($currentPage > 1) {
            $pagingStr = '<a data-page="'.($currentPage - 1).'" href="' . $searchSuffix . '/p' . ($currentPage - 1) . '" class="prev">上一页</a>';
        }
        if ($totalPage <= 11) {
            $pagingStr .= self::partPaging($searchSuffix, $totalPage, $currentPage);
        } elseif ($totalPage > 11) {
            if ($currentPage < 7) {
                $pagingStr .= self::partPaging($searchSuffix, 7, $currentPage);
                $pagingStr .= '<a href = "javascript:void(0);" class="more" >...</a >';
                $pagingStr .= self::partPaging($searchSuffix, $totalPage, $currentPage, $totalPage - 2);
            } elseif ($totalPage - 7 < $currentPage) {
                $pagingStr .= self::partPaging($searchSuffix, 2, $currentPage);
                $pagingStr .= '<a href = "javascript:void(0);" class="more" >...</a >';
                $pagingStr .= self::partPaging($searchSuffix, $totalPage, $currentPage, $totalPage - 7);
            } else {
                $pagingStr .= self::partPaging($searchSuffix, 2, $currentPage);
                $pagingStr .= '<a href = "javascript:void(0);" class="more" >...</a >';
                $pagingStr .= self::partPaging($searchSuffix, $currentPage + 2, $currentPage, $currentPage - 2);
                $pagingStr .= '<a href = "javascript:void(0);" class="more" >...</a >';
                $pagingStr .= self::partPaging($searchSuffix, $totalPage, $currentPage, $totalPage - 2);
            }
        }
        if ($totalPage != $currentPage) {
            $pagingStr .= '<a data-page='. ($currentPage + 1) .' href="' . $searchSuffix . '/p' . ($currentPage + 1) . '" class="next" > 下一页</a >';
        }
        $pagingStr .= '<span class="info">共' . $totalPage . '页</span>';
        return $pagingStr;
    }

    protected static function partPaging($searchSuffix,$total,$currentPage,$start = 1)
    {
        $pagingStr = '';
        for($i=$start;$i<=$total;$i++)
        {
            if($i == $currentPage)
            {
                $pagingStr .= '<a data-page="'.($i).'" href="'.$searchSuffix.'/p'.$i.'" class="cur">'.$i.'</a>';
            }
            else
            {
                $pagingStr .= '<a data-page="'.($i).'" href="'.$searchSuffix.'/p'.$i.'">'.$i.'</a>';
            }
        }
        return $pagingStr;
    }

    /**
     * @todo utf-8截取
     *
     * @author Justin.W
     * @param sting $string
     * @param int $start
     * @param int $sublen
     * @param boolean $append
     * @return string
     */
    public static function cututf8($string, $start = 0, $sublen=40, $append = true) {
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all ( $pa, $string, $t_string );
        if (count ( $t_string [0] ) - $start > $sublen && $append == true) {
            return join ( '', array_slice ( $t_string [0], $start, $sublen ) ) . "...";
        } else {
            return join ( '', array_slice ( $t_string [0], $start, $sublen ) );
        }
    }
    /**
     * 字符串截取，支持中文和其他编码 一个汉字就是一个字符 njz20151013
     *
     * @param string $str 需要转换的字符串
     * @param string $start 开始位置
     * @param string $length 截取长度
     * @param string $charset 编码格式
     * @param string $suffix 截断字符串后缀
     * @return string
     */
    public static function  substr_ext($str, $start=0, $length, $charset="utf-8", $suffix="")
    {
        if($length>=mb_strlen($str) )
        {
            $suffix = '';
        }
        if(function_exists("mb_substr")){
            return mb_substr($str, $start, $length, $charset).$suffix;
        }
        elseif(function_exists('iconv_substr')){
            return iconv_substr($str,$start,$length,$charset).$suffix;
        }
        $re['utf-8']  = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
        $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
        $re['gbk']    = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
        $re['big5']   = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
        return $slice.$suffix;
    }

    /**
     * @todo  判断访问来源平台
     * 
     * @author  Justin.W
     * @since   $id
     * @return  int
     * 
     */
    public static function judgmentPlatform()
    {
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad'))
        { 
            return 1; 
        }
        elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Android'))
        { 
            return 1;
        }
        else
        {
            return 0;
        }
    }

    /**
     * 删除价格后的0 njz20151015
     *
     * @param $s
     * @return mixed|string
     */
    public static function del0($s)
    {
        $s = trim(strval($s));
        if (preg_match('#^-?\d+?\.0+$#', $s)) {
            return preg_replace('#^(-?\d+?)\.0+$#','$1',$s);
        }
        if (preg_match('#^-?\d+?\.[0-9]+?0+$#', $s)) {
            return preg_replace('#^(-?\d+\.[0-9]+?)0+$#','$1',$s);
        }
        return $s;
    }
    /**
     *  移除html标签 njz20151019
     * @param type $str
     */
    public static function removeHtmls($str){
        $str = strip_tags($str,"");
        $str = preg_replace("/<script.*?>(\s|.)*?<\/script>/i","",$str);
        $str = trim($str);
        if (!get_magic_quotes_gpc()){
            return htmlspecialchars(addslashes($str));
        }else{
            return $str;
        }
    }
    /**
     * @todo 字符串过滤
     *
     * @author Justin.W
     * @param $data
     * @return array|string
     */
    public static function filterData(&$data){
        if(is_array($data)){
            foreach($data as $key => $val){
                if(is_array($val)){
                    self::filterData($val);
                }else{
                    $data[$key] = htmlspecialchars($val);
                }
            }
        }else{
            $data = htmlspecialchars($data);
        }
        return $data;
    }
}
