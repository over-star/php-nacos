<?php

namespace Overstar\PhpNacos\Request;

use Overstar\PhpNacos\Request\ConfigRequest;

/**
 * Class GetConfigRequest
 * @author suxiaolin
 * @package alibaba\nacos\Request\config
 */
class GetConfigRequest extends ConfigRequest
{
    protected $uri = "/nacos/v1/cs/configs";
    protected $verb = "GET";

}