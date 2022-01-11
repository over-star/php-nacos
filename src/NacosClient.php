<?php


namespace Overstar\PhpNacos;


use Exception;
use Overstar\PhpNacos\Exceptions\RequestException;
use Overstar\PhpNacos\Helpers\LogHelper;
use Overstar\PhpNacos\Helpers\SnapshotHelper;
use Overstar\PhpNacos\Request\DeleteConfigRequest;
use Overstar\PhpNacos\Request\GetConfigRequest;
use Overstar\PhpNacos\Request\LongPollingConfigRequest;
use Overstar\PhpNacos\Request\PublishConfigRequest;


class NacosClient
{
    public static function listener($dataId, $group, $config, $tenant = "")
    {
        LogHelper::info("配置长轮询监听已经启动..... ");
        $loop = 0;
        $store=[];
        if(!is_array($dataId)){
            $dataId=[$dataId];
        }
        do {
            $loop++;
            foreach ($dataId as $key => $id) {
                $store[$key]['config']=self::one($id, $group, $tenant, $store[$key]['config']??"");
            }
            LogHelper::info("监听轮次：{$loop}");
            sleep(1);
        } while (true);
    }


    public static function run($dataId, $group, $tenant = "")
    {
        $config = self::get($dataId, $group, $tenant);
        SnapshotHelper::saveSnapshot($dataId, $config);
    }

    public static function get($dataId, $group, $tenant)
    {
        $getConfigRequest = new GetConfigRequest();
        $getConfigRequest->setDataId($dataId);
        $getConfigRequest->setGroup($group);
        $getConfigRequest->setTenant($tenant);
        try {
            $response = $getConfigRequest->doRequest();
            $config   = $response->getBody()->getContents();
        } catch (Exception $e) {
            $message = "获取配置异常, message: " . $e->getMessage();
            LogHelper::error($message);
            throw new RequestException($message, $e->getCode());
        }
        return $config;
    }

    public static function publish($dataId, $group, $tenant, $args)
    {
        $publishConfigRequest = new PublishConfigRequest();
        $publishConfigRequest->setDataId($dataId);
        $publishConfigRequest->setGroup($group);
        $publishConfigRequest->setTenant($tenant);
        $publishConfigRequest->setContent($args[0]);
        $publishConfigRequest->setType(isset($args[1]) ? $args[1] : 'text');
        try {
            $response = $publishConfigRequest->doRequest();
        } catch (Exception $e) {
            $message = "发布配置异常, message: " . $e->getMessage();
            LogHelper::error($message);
            throw new RequestException($message, $e->getCode());
        }
        return $response->getBody()->getContents() == "true";
    }

    public static function delete($dataId, $group, $tenant)
    {
        $deleteConfigRequest = new DeleteConfigRequest();
        $deleteConfigRequest->setDataId($dataId);
        $deleteConfigRequest->setGroup($group);
        $deleteConfigRequest->setTenant($tenant);
        $response = $deleteConfigRequest->doRequest();
        return $response->getBody()->getContents() == "true";
    }

    /**
     * @param $dataId
     * @param $group
     * @param  $tenant
     * @param string $config
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function one($dataId, $group, $tenant, string $config)
    {
        $listenerConfigRequest = new LongPollingConfigRequest();
        $listenerConfigRequest->setDataId($dataId);
        $listenerConfigRequest->setGroup($group);
        $listenerConfigRequest->setTenant($tenant);
        $listenerConfigRequest->setContentMD5(md5($config));
        try {
            $response = $listenerConfigRequest->doRequest();
            if ($response->getBody()->getContents()) {
                // 配置发生了变化
                $config = self::get($dataId, $group, $tenant);
                LogHelper::info("[{$dataId}]配置发生了变化: " . $config);
                SnapshotHelper::saveSnapshot($dataId, $config);
                return $config;
            }
            return $config;
        } catch (Exception $e) {
            LogHelper::error("listener请求异常, e: " . $e->getMessage());
            sleep(2);
        }
        return "";
    }
}
