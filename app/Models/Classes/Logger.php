<?php namespace Models\Classes;

use Models\Brokers\LogBroker;

class Logger
{
    public static function logUser(string $username)
    {
        $broker = new LogBroker();
        $log = new Log($username);
        $log->build();
        $broker->insert($log);
    }
}
