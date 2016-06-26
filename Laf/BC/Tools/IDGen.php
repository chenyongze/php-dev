<?php
/**
 * Created by PhpStorm.
 * User: wang hao
 * Create Time: 14-9-19 10:20
 * Modify Time: 14-9-19 10:20
 *
 *
 *
 *
 * 使用方式，config新建idgen.php
 * return [
 * 'default' => [
 * 'start_number'        => 100000000,            //id开始
 * 'end_number'          => 4294966295,           //id结束
 * 'package_size'        => 1000,                 //单个ID包大小
 * 'redis_put_per_times' => 5000000,              //单次redis传输数据量限制
 * 'redis_server'        => 'passport',           //redis服务（依赖databse的config）
 * 'redis_key'           => 'passport_user',      //redis key
 * 'threshold'           => 10000,                //id发放阈值
 * 'grant_per_times'     => 10000,                //每次最少发放ID数（不能固定发，因为单个package是不能拆分的）
 * ]
 * ];
 */

namespace BC\Tools;


class IDGen
{
	const KEY_PRIFIX     = 'IDGEN_';
	const SUBKEY_PACKAGE = '_PKG';
	const SUBKEY_IDS     = '_IDS';

	/**
	 * 初始化数据库
	 * @param string $config_key
	 * @return int 生成的package数
	 * @throws \Exception
	 */
	public static function initDB($config_key = 'default')
	{
		$config = static::getConfig($config_key);
		$redis  = \Redis::connection($config['redis_server']);
		if ($redis->exists($config['key_pkg'])) {
			throw new \Exception('数据库已存在');
		}
		$scopes = range($config['start_number'], $config['end_number'], $config['package_size']);
		if (count($scopes) > $config['redis_put_per_times']) while (count($scopes) > $config['redis_put_per_times']) {
			$scopes_step = array_splice($scopes, 0, $config['redis_put_per_times']);
			$redis->sadd($config['key_pkg'], $scopes_step);
		}
		count($scopes) && $redis->sadd($config['key_pkg'], $scopes);

		return $redis->scard($config['key_pkg']);
	}

	/**
	 * 发放ID（手动或者定时用）
	 * @param bool $message
	 * @param string $config_key
	 * @throws \Exception
	 * @return int 本次发放ID数
	 */
	public static function grantID(&$message = false, $config_key = 'default')
	{
		$config = static::getConfig($config_key);
		$redis  = \Redis::connection($config['redis_server']);
		if (!$redis->exists($config['key_pkg'])) {
			throw new \Exception('数据库不存在');
		}
		$total   = $redis->scard($config['key_id']);
		$granted = 0;
		if ($total > $config['threshold']) {
			$message = sprintf('ID还有%d个，大于阈值%d,无需发放', $total, $config['threshold']);
		} else {
			$times = 0;
			while ($granted < $config['grant_per_times']) {
				$pkg = $redis->spop($config['key_pkg']);
				$ids = range($pkg, $pkg + $config['package_size'] - 1);
				$redis->sadd($config['key_id'], $ids);
				$granted += count($ids);
				$times++;
			}
			$total   = $redis->scard($config['key_id']);
			$message = sprintf('分%d次，发放了%d个ID，当前库存为%d', $times, $granted, $total);
		}

		return $granted;
	}

	/**
	 * 生成ID
	 * @param string $config_key
	 * @throws \Exception
	 */
	public static function genID($config_key = 'default')
	{
		$config = static::getConfig($config_key);
		$redis  = \Redis::connection($config['redis_server']);
		if (!$redis->exists($config['key_pkg']) || !$redis->exists($config['key_id'])) {
			throw new \Exception('数据库不存在');
		}
		$id = $redis->spop($config['key_id']);
		if (!$id) {
			throw new \Exception('ID池空了！');
		}

		return $id;
	}

	/**
	 * 获取配置文件
	 * @param string $config_key
	 * @throws \Exception
	 */
	private static function getConfig($config_key = 'default')
	{
		$config = \Config::get('idgen');

		if (isset($config) && isset($config[ $config_key ])) {
			$config            = $config[ $config_key ];
			$config['key_pkg'] = static::KEY_PRIFIX . $config['redis_key'] . static::SUBKEY_PACKAGE;
			$config['key_id']  = static::KEY_PRIFIX . $config['redis_key'] . static::SUBKEY_IDS;

			return $config;
		} else {
			throw new \Exception('配置文件不存在');
		}

	}
} 