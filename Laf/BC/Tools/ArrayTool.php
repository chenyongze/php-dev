<?php
namespace BC\Tools;
class ArrayTool {
    /**
     * 对值为Object类型的数组排重 njz20151217
     * @param $array
     * @return mixed
     */
    static function arrayUnique($array)
    {
        foreach ($array as $k => $v) {
            foreach ($array as $k2 => $v2) {
                if (($v2 == $v) && ($k != $k2)) {
                    unset($array[$k]);
                }
            }
        }
        return $array;
    }
    /**
     * 二维数组排序(td是two-dimension的意思)
     *
     * @param array $arr
     * @param string $fieldA
     * @param string $sortA
     * @param string $fieldB
     * @param string $sortB
     * @param string $fieldC
     * @param string $sortC
     */
    static function tdSort(&$arr, $fieldA, $sortA = SORT_ASC, $fieldB = '', $sortB = SORT_ASC, $fieldC = '', $sortC = SORT_ASC) {
        if (!is_array($arr) || count($arr) < 1) {
            return false;
        }
        $arrTmp = array();
        foreach ($arr as $rs) {
            foreach ($rs as $key => $value) {
                $arrTmp["{$key}"][] = $value;
            }
        }
        if (empty($fieldB)) {
            if (!$arrTmp[$fieldA]) {
                return false;
            }
            array_multisort($arrTmp[$fieldA], $sortA, $arr);
        } elseif (empty($fieldC)) {
            if (!$arrTmp[$fieldA] || !$arrTmp[$fieldB]) {
                return false;
            }
            array_multisort($arrTmp[$fieldA], $sortA, $arrTmp[$fieldB], $sortB, $arr);
        } else {
            if (!$arrTmp[$fieldA] || !$arrTmp[$fieldB] || !$arrTmp[$fieldC]) {
                return false;
            }
            array_multisort($arrTmp[$fieldA], $sortA, $arrTmp[$fieldB], $sortB, $arrTmp[$fieldC], $sortC, $arr);
        }
        return true;
    }

    /**
     * 重新设置数组索引
     *
     * @param array $arr
     * @param string $field
     * @return array
     */
    static function resetIndex(&$arr, $field) {
        if (!is_array($arr)) {
            return array();
        }
        foreach ($arr as $row) {
            $tmp[$row[$field]] = $row;
        }
        $arr = $tmp;
        return $arr;
    }
}