<?php


use Overstar\PhpNacos\Nacos;
include '../vendor/autoload.php';

//Nacos::init( "http://119.91.83.91:8848/", "console.php", "js", "0c1201b3-495a-4c14-9259-e798b64fb6e8" )
//    ->run();

//Nacos::init( "http://119.91.83.91:8848/", "console.php", "js", "0c1201b3-495a-4c14-9259-e798b64fb6e8" )
//    ->listener();

//$dataId, $group, $content, $tenant = ""

//Nacos::init( "http://119.91.83.91:8848/", "console.php", "js", "0c1201b3-495a-4c14-9259-e798b64fb6e8" )
//    ->publish("sdfsdfsdf","text");

Nacos::init( "http://119.91.83.91:8848/", "console.php", "js", "0c1201b3-495a-4c14-9259-e798b64fb6e8" )
    ->delete();