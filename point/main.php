<?php
set_time_limit(0);

//include "./english.php";    //sql语句中 course =3
include "./math.php";       //sql语句中 course =2


//$con = mysql_connect("10.2.1.124:3306", "wenba", "Ib5mvmxbrIgsjjhcOhx7m39agrvPpxlr");
$con = mysql_connect("10.2.1.124:3307", "wenba", "wenbatest");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("wenba_live", $con);

mysql_query("SET NAMES 'utf8'");

import_data($arrPoints);

function import_data($info, $pid = 0)
{
    foreach ($info as $k1 => $v1) {
        $id1 = insert($k1, 0);
        if (!empty($v1)) {
            foreach ($v1 as $k2 => $v2) {
                $id2 = insert($k2, $id1);
                if (!empty($v2)) {
                    foreach ($v2 as $k3 => $v3) {
                        $id3 = insert($k3, $id2);
                        if (!empty($v3)) {
                            foreach ($v3 as $k4 => $v4) {
                                $id4 = insert($k4, $id3);
                                if (!empty($id4)) {
                                    foreach ($v4 as $k5 => $v5) {
                                        $id5 = insert($k5, $id4);
                                        if (!empty($id5)) {
                                            foreach ($v5 as $k6 => $v6) {
                                                $id6 = insert($k6, $id5);
                                                if (!empty($id6)) {
                                                    foreach ($v6 as $k7 => $v7) {
                                                        $id7 = insert($k7, $id6);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}


function insert($title, $pid = '0')
{
    $sql = "INSERT INTO wenba_live_knowledge_point (title, parent, status, course) VALUES ('{$title}', {$pid},1,2)";
    mysql_query($sql);
    return mysql_insert_id();
}
