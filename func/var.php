<?php
$a = array (1, 2, array ("a", "b", "c"));
// var_export ($a);
echo var_export ($a,1);
/* 输出：
array (
  0 => 1,
  1 => 2,
  2 => 
  array (
    0 => 'a',
    1 => 'b',
    2 => 'c',
  ),
)
*/