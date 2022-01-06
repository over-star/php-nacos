<?php


namespace Overstar\PhpNacos\Helpers;


use GuzzleHttp\Client;
use Overstar\PhpNacos\NacosConfig;

class HttpHelper
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function request($verb, $uri, $body = [], $headers = [], $options = [])
    {
        $httpClient = self::getGuzzle();
        $parameterList = [
            'headers' => $headers,
        ];
        if ($verb == "GET") {
            $parameterList['query'] = $body;
        } else {
            $parameterList['form_params'] = $body;
        }
        return $httpClient->request($verb, $uri, array_merge($parameterList, $options));
    }

    /**
     * @param $host
     * @param $timeout
     * @return Client
     */
    public static function getGuzzle()
    {
        static $guzzle;
        if ($guzzle == null) {
            $guzzle = new Client([
                'base_uri' => NacosConfig::getHost(),
            ]);
        }
        return $guzzle;
    }

}