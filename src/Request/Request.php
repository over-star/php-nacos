<?php

namespace Overstar\PhpNacos\Request;

use GuzzleHttp\Exception\GuzzleException;
use Overstar\PhpNacos\Exceptions\RequestException;
use Overstar\PhpNacos\Helpers\EncodeHelper;
use Overstar\PhpNacos\Helpers\ErrorCodeHelper;
use Overstar\PhpNacos\Helpers\HttpHelper;
use Overstar\PhpNacos\NacosConfig;
use ReflectionException;


/**
 * Class Request
 * @author suxiaolin
 * @package alibaba\nacos\Request
 */
abstract class Request
{
    /**
     * 接口地址
     * @var
     */
    protected $uri;

    /**
     * 接口动词
     * @var
     */
    protected $verb;

    /**
     * 忽略这些属性
     *
     * @var array
     */
    protected $standaloneParameterList = ["uri", "verb"];

    /**
     * 发起请求，做返回值异常检查
     *
     * @throws RequestException
     * @throws ReflectionException|GuzzleException
     */
    public function doRequest()
    {
        list($parameterList, $headers) = $this->getParameterAndHeader();
        $response = HttpHelper::request(
            $this->getVerb(),
            $this->getUri(),
            $parameterList,
            $headers
        );

        if (isset(ErrorCodeHelper::getErrorCodeMap()[$response->getStatusCode()])) {
            throw new RequestException(ErrorCodeHelper::getErrorCodeMap()[$response->getStatusCode()],$response->getStatusCode());
        }
        return $response;
    }

    /**
     * 获取请求参数和请求头
     * @return array
     * @throws ReflectionException
     */
    abstract protected function getParameterAndHeader();

    /**
     * @return mixed
     * @throws
     */
    public function getVerb()
    {
        return $this->verb;
    }

    /**
     * @param mixed $verb
     */
    public function setVerb($verb)
    {
        $this->verb = $verb;
    }

    /**
     * @return mixed
     * @throws
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

}