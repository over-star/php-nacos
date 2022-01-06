<?php


namespace Overstar\PhpNacos\Helpers;

use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Overstar\PhpNacos\NacosConfig;

class LogHelper
{
    /**
     * @param $message
     * @param $parameters
     */
    public static function info($message, $parameters = [])
    {
        self::getLog()->info($message, $parameters);
    }

    public static function getLog()
    {
        static $log;
        if ($log == null) {
            try {
                $log = new Logger(NacosConfig::getName());
                $log->pushHandler(new StreamHandler(NacosConfig::getLogPath(), NacosConfig::getLogLevel()));
            } catch (Exception $e) {
                echo "初始化日志系统失败";
                exit(255);
            }
        }
        return $log;
    }

    /**
     * @param $message
     * @param $parameters
     */
    public static function error($message, $parameters = [])
    {
        self::getLog()->error($message, $parameters);
    }
}