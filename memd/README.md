## php的memcached扩展下载
https://pecl.php.net/package/memcached


## 官网手册：
http://php.net/memcached

## 预定义常量 ¶
- Memcached::OPT_LIBKETAMA_COMPATIBLE   设置为md5并且分布算法将会 采用带有权重的一致性hash分布
- Memcached::OPT_CONNECT_TIMEOUT, 100);     在非阻塞模式下这里设置的值就是socket连接的超时时间，单位是毫秒。 类型: integer, 默认: 1000.
- Memcached::OPT_POLL_TIMEOUT       poll连接超时时间，单位毫秒。类型: integer, 默认: 1000.

## 方法
```php
public bool Memcached::set ( string $key , mixed $value [, int $expiration ] )
```