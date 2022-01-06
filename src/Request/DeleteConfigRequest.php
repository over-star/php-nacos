<?php

namespace Overstar\PhpNacos\Request;


class DeleteConfigRequest extends ConfigRequest
{
    protected $uri = "/nacos/v1/cs/configs";
    protected $verb = "DELETE";
}