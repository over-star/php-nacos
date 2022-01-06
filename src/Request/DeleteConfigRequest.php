<?php

namespace Overstar\PhpNacos\Request;

/**
 * Class DeleteConfigRequest
 * @author suxiaolin
 * @package alibaba\nacos\Request\config
 */
class DeleteConfigRequest extends ConfigRequest
{
    protected $uri = "/nacos/v1/cs/configs";
    protected $verb = "DELETE";
}