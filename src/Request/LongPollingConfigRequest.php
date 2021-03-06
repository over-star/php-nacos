<?php


namespace Overstar\PhpNacos\Request;

use Overstar\PhpNacos\Helpers\EncodeHelper;
use Overstar\PhpNacos\NacosConfig;


class LongPollingConfigRequest extends ConfigRequest
{
    /**
     * 监听数据报文。格式为 dataId^2Group^2contentMD5^2tenant^1或者dataId^2Group^2contentMD5^1。
     */
    const LISTENING_CONFIGS_FORMAT = "%s%s%s%s%s%s%s%s";

    protected $uri = "/nacos/v1/cs/configs/listener";
    protected $verb = "POST";

    /**
     * 监听数据报文
     * @var
     */
    private $listeningConfigs;

    /**
     * 配置内容 MD5 值
     *
     * @var
     */
    private $contentMD5;

    /**
     * @var int 长轮询等待时间, 默认30秒
     */
    private $longPullingTimeout;

    /**
     * @return int
     */
    public function getLongPullingTimeout()
    {
        if ($this->longPullingTimeout) {
            return $this->longPullingTimeout;
        } else {
            return NacosConfig::getLongPullingTimeout();
        }
    }

    /**
     * @return mixed
     */
    public function getListeningConfigs()
    {
        $this->listeningConfigs = sprintf(
            self::LISTENING_CONFIGS_FORMAT,
            $this->getDataId(),
            EncodeHelper::twoEncode(),
            $this->getGroup(),
            EncodeHelper::twoEncode(),
            $this->getContentMD5(),
            EncodeHelper::twoEncode(),
            $this->getTenant(),
            EncodeHelper::oneEncode()
        );
        return $this->listeningConfigs;
    }

    /**
     * @return mixed
     */
    public function getContentMD5()
    {
        return $this->contentMD5;
    }

    /**
     * @param mixed $contentMD5
     */
    public function setContentMD5($contentMD5)
    {
        $this->contentMD5 = $contentMD5;
    }
}