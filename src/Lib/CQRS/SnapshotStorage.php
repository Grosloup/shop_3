<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 13/01/17
 * Time: 15:59
 */

namespace Lib\CQRS;


interface SnapshotStorage
{
    public function getLastSnapshot($uuid);
}