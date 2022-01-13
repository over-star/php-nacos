<?php

namespace Overstar\PhpNacos;

class Nacos
{
    private static $clientClass;

    public static function init($host, $dataId, $group, $tenant)
    {
        static $client;
        if ($client == null) {
            NacosConfig::setHost($host);
            NacosConfig::setDataId($dataId);
            NacosConfig::setGroup($group);
            NacosConfig::setTenant($tenant);
            self::$clientClass = NacosClient::class;
            $client            = new self();
        }
        return $client;
    }

    public function run()
    {
        call_user_func_array([self::$clientClass, "run"], [NacosConfig::getDataId(), NacosConfig::getGroup(), NacosConfig::getTenant()]);
        return $this;
    }

    public function listener()
    {
        call_user_func_array([self::$clientClass, "listener"], [NacosConfig::getDataId(), NacosConfig::getGroup(), NacosConfig::getTenant()]);
        return $this;
    }

    public function __call($name, $args)
    {
        call_user_func_array([self::$clientClass, $name], [NacosConfig::getDataId(), NacosConfig::getGroup(), NacosConfig::getTenant(), $args]);
        return $this;
    }
}
