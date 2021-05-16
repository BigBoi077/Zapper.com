<?php namespace Models\Brokers;

use Models\Classes\Log;
use Models\Classes\Queries;

class LogBroker extends Broker
{
    public function insert(Log $log)
    {
        $sql = Queries::getInsertLogQuery();
        $this->query($sql, [
            $log->ip,
            $log->username,
            $log->timestamp,
            $log->method,
            $log->port,
            $log->userAgent,
            $log->protocol
        ]);
    }
}
