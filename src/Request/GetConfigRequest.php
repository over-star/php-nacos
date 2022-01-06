<?php

namespace Overstar\PhpNacos\Request;

use Overstar\PhpNacos\Request\ConfigRequest;


class GetConfigRequest extends ConfigRequest
{
    protected $uri = "/nacos/v1/cs/configs";
    protected $verb = "GET";

}