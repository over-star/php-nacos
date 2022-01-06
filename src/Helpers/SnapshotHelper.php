<?php

namespace Overstar\PhpNacos\Helpers;


use Overstar\PhpNacos\NacosConfig;
use SplFileInfo;

class SnapshotHelper
{
    const DS = DIRECTORY_SEPARATOR;



    public static function getSnapshotFile($dataId)
    {
        return NacosConfig::getSavePath() . self::DS . $dataId;
    }

    public static function saveSnapshot($dataId, $config)
    {
        $snapshotFile = self::getSnapshotFile($dataId);
        echo $snapshotFile;
        if (!$config) {
            @unlink($snapshotFile);
        } else {
            $file = new SplFileInfo($snapshotFile);
            if (!is_dir($file->getPath())) {
                mkdir($file->getPath(), 0777, true);
            }
            file_put_contents($snapshotFile, $config);
        }
    }

}
