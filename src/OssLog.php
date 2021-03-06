<?php

/**
 * Created by PhpStorm.
 * User: Eric.Wang
 * Date: 2017/1/18
 * Time: 9:38
 */

namespace gaodun\osslog;

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
        $this->object = OSS_PREFIX.date('Y-m-d').'-'.uniqid();
        $this->ossClient = new OssClient(OSS_ACCESS_KEY_ID, OSS_ACCESS_KEY_SECRET, OSS_END_POINT);
    }

    public function write(array $record)
    {
        try {
            $this->ossClient->putObject(OSS_LOG_BUKET, $this->object, $record['formatted']);
        } catch (OssException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}