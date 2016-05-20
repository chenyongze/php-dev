<?php

require('redis.php');


//$uid = $redis->incr('userId');
//$redis->rPush('userid', $uid);
//$res= $redis->hMset('user'.$uid, [
//    'uid' => $uid,
//    'username' => $username,
//    'password' => $password,
//    'age' => $age
//]);

////自增ID
//dd($redis->get('userId'));
//
//dd($ids = $redis->lRange('userid',0,-1));
//
//foreach ($ids as $id)
//{
//    $data[] = $redis->hGetAll('user'.$id);
//}
//
dd($data);
//==========================================

//string
//$redis->set('x', '42');
////$redis->setTimeout('x', 3); // x will disappear in 3 seconds.
//$redis->expire('x', 3); // x will disappear in 3 seconds.
//dd($redis->get('x'));
//dd($redis->ttl('x'));
//sleep(5);               // wait 5 seconds
//dd($redis->get('x'));
//
//dd($redis->keys('*'));
//dd($count = $redis->dbSize());

//$redis->flushAll();
//使用aof来进行数据库持久化
//$redis->bgrewriteaof();
////异步保存到磁盘。
//$redis->bgSave();

//* - string: Redis::REDIS_STRING   1
//* - set:   Redis::REDIS_SET       2
//* - list:  Redis::REDIS_LIST      3
//* - zset:  Redis::REDIS_ZSET      4
//* - hash:  Redis::REDIS_HASH      5
//* - other: Redis::REDIS_NOT_FOUND 0
//dd($redis->type('x'));


////LIST
//$redis->del('key1');
//$redis->rPush('key1', 'A'); // returns 1
//$redis->rPush('key1', 'B'); // returns 2
//$redis->rPush('key1', 'C'); // returns 3
//dd($redis->lSize('key1'));/* 3 */
//dd($redis->lRange('key1',0,-1));
////$redis->rPop('key1'); /* key1 => [ 'A', 'B' ] */
////dd($redis->lRange('key1',0,-1));
//
///*
// * 截取LIST。
// * Parameters   key start stop
// * Return Array
// */
////$redis->lTrim('key1', 0, 1);
////dd($redis->lRange('key1', 0, -1)); /* array('A', 'B') */
//
////根据索引值返回指定KEY LIST中的元素。0为第一个元素，1为第二个元素。-1为倒数第一个元素
//dd($redis->lGet('key1', 0)); /* 'A' */
//dd($redis->lGet('key1', -1)); /* 'C' */
//
////根据索引值设置新的VAULE
////Parameters  key index value
//$redis->lSet('key1', 0, 'X');
//$redis->lGet('key1', 0); /* 'X' */


//hash
//$redis->delete('h');
//$redis->hSet('h', 'key1', 'hello'); /* 1, 'key1' => 'hello' in the hash at "h" */
//$redis->hSet('h', 'key2', 'world'); /* 1, 'key1' => 'hello' in the hash at "h" */
//dd($redis->hGet('h', 'key1')); /* returns "hello" */
//dd($redis->hGet('h', 'key2')); /* returns "hello" */
//
//$redis->hSet('h', 'key1', 'plop'); /* 0, value was replaced. */
//dd($redis->hGet('h', 'key1')); /* returns "plop" */
//dd($redis->hGet('h', 'key2')); /* returns "plop" */
//
//
//dd($redis->hLen('h')); /* returns 2 */
//dd($redis->hGetAll('h'));
////删除
//$redis->hDel('h','key2');
//
//dd($redis->hGetAll('h'));
//
//
//$redis->delete('user:1');
//$redis->hMset('user:1', array('name' => 'Joe', 'salary' => 2000));
//$redis->hIncrBy('user:1', 'salary', 100); // Joe earns 100 more now.
//
//
//$redis->delete('h');
//$redis->hSet('h', 'field1', 'value1');
//$redis->hSet('h', 'field2', 'value2');
//$redis->hmGet('h', array('field1', 'field2')); /* returns array('field1' => 'value1', 'field2' => 'value2') */
//
//$redis->delete('h');
//$redis->hSet('h', 'a', 'x');
//$redis->hSet('h', 'b', 'y');
//$redis->hSet('h', 'c', 'z');
//$redis->hSet('h', 'd', 't');
//dd($redis->hGetAll('h'));


//set
//结果集的顺序是随机的，这也符合Redis本身对SET数据结构的定义。不重复，无顺序的集合。
//$redis->delete('s');
//$redis->sAdd('s', 'a');
//$redis->sAdd('s', 'b');
//$redis->sAdd('s', 'a');  //false
//$redis->sAdd('s', 'c');
//
////返回SET集合中的所有元素。
//dd($redis->sMembers('s'));


$redis->delete('key1');
$redis->delete('key2');
$redis->delete('key3');
//$redis->sAdd('key1', 'val1');
//$redis->sAdd('key1', 'val2');
//$redis->sAdd('key1', 'val3');
//$redis->sAdd('key1', 'val4');
//$redis->sAdd('key1', 'val6');
//
//$redis->sAdd('key2', 'val3');
//$redis->sAdd('key2', 'val4');
//
//$redis->sAdd('key3', 'val2');
//$redis->sAdd('key3', 'val3');
//$redis->sAdd('key3', 'val5');
//
////取交集
//dd($redis->sInter('key1', 'key2', 'key3'));
//
////取并集
//dd($redis->sUnion('key1', 'key2', 'key3'));
//
////取差集
////SET0 - (SET1 UNION SET2 UNION ....SET N))
//dd($redis->sDiff('key1', 'key2', 'key3'));
//
////执行一个交集操作，并把结果存储到一个新的SET容器中。
//var_dump($redis->sInterStore('output', 'key1', 'key2', 'key3'));
//var_dump($redis->sMembers('output'));


////移除
//$redis->sAdd('key1' , 'member1');
//$redis->sAdd('key1' , 'member2');
//$redis->sAdd('key1' , 'member3'); /* 'key1' => {'member1', 'member2', 'member3'}*/
////$redis->sRem('key1', 'member2'); /* 'key1' => {'member1', 'member3'} */
//
////返回SET容器的成员数
//$redis->sCard('key1'); /* 3 */
//
////随机返回一个元素，并且在SET容器中移除该元素。
//$redis->sAdd('key1' , 'member1');
//$redis->sAdd('key1' , 'member2');
//$redis->sAdd('key1' , 'member3'); /* 'key1' => {'member3', 'member1', 'member2'}*/
//$redis->sPop('key1'); /* 'member1', 'key1' => {'member3', 'member2'} */
//$redis->sPop('key1'); /* 'member3', 'key1' => {'member2'} */
//
////取得指定SET容器中的一个随机元素，但不会在SET容器中移除它。
//$redis->sAdd('key1' , 'member1');
//$redis->sAdd('key1' , 'member2');
//$redis->sAdd('key1' , 'member3'); /* 'key1' => {'member3', 'member1', 'member2'}*/
//$redis->sRandMember('key1'); /* 'member1', 'key1' => {'member3', 'member1', 'member2'} */
//$redis->sRandMember('key1'); /* 'member3', 'key1' => {'member3', 'member1', 'member2'} */




