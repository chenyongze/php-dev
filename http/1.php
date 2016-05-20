<?php

error_log("11111111");

$array['1'] = array('key_a' => 'a', 'key_b' => '2');
$array['2'] = array('key_a' => 'b', 'key_b' => '1');
$array['3'] = array('key_a' => 'c', 'key_b' => '1');

uasort($array, function ($a, $b) {
        if($a['key_b'] == $b['key_b'])
            return 0;
        return ($a['key_b']<$b['key_b']) ? -1: 1;
    }
);
var_dump($array);
