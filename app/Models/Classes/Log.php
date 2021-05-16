<?php namespace Models\Classes;

class Log
{
    public String $username;
    public String $ip;
    public String $timestamp;
    public String $port;
    public String $userAgent;
    public String $protocol;
    public String $method;

    public function __construct(String $username)
    {
        $this->username = $username;
    }

    public function build()
    {
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->timestamp = date(FORMAT_DATE_TIME);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->port = $_SERVER['SERVER_PORT'];
        $this->protocol = $_SERVER['SERVER_PROTOCOL'];
    }
}
