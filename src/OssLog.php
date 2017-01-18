<?php

/**
 * Created by PhpStorm.
 * User: Eric.Wang
 * Date: 2017/1/18
 * Time: 9:38
 */

namespace gaodun\log;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use OSS\OssClient;
use OSS\Core\OssException;

class OssLog extends AbstractProcessingHandler
{
    public $ossClient;
    public $object;

    public function __construct()
    {
        $this->object = uniqid();
        $this->ossClient = new OssClient(OSS_ACCESS_KEY_ID, OSS_ACCESS_KEY_SECRET, OSS_END_POINT);
    }

    public function write(array $record)
    {
        foreach ($record as $val) {
            if (!isset($position)) {
                $position = 0;
            }
            $position = $this->ossClient->appendObject(OSS_LOG_BUKET, $this->object, $val, $position);
        }
    }
}