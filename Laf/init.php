<?php
/**
 * Created by PhpStorm.
 * User: chao
 * Date: 16/6/25
 * Time: 下午4:25
 */

define('ENVIRONMENT', isset($_SERVER['APP_ENV']) ? $_SERVER['APP_ENV'] : 'development');
define('BASE_URL', 'http://i-vip.cn/');

$application_folder = 'app';

switch (ENVIRONMENT)
{
    case 'development':
        //ini_set('display_errors', 0);
        ini_set('display_errors', 'On');
        error_reporting(E_ALL);
        break;

    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>='))
        {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        }
        else
        {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        }
        break;

    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1);
}

if (is_dir($application_folder))
{
    if (($_temp = realpath($application_folder)) !== FALSE)
    {
        $application_folder = $_temp;
    }

    define('APP_PATH', $application_folder.DIRECTORY_SEPARATOR);
}


define('LOG_PATH', realpath(dirname(__FILE__) . '/data/log') . DIRECTORY_SEPARATOR);
define('PUBLIC_PATH', realpath(dirname(__FILE__) . '/public') . DIRECTORY_SEPARATOR);

require APP_PATH."../vendor/autoload.php";
require APP_PATH."/Config/common.php";
require APP_PATH."/Helpers/common.php";