<?php namespace Models;

class Log
{
    private String $username;
    private String $ip;
    private String $timestamp;
    private String $port;
    private String $userAgent;
    private String $protocol;
    private String $method;

    public function __construct(String $username)
    {
        $this->username = $username;
    }

    public function build()
    {
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->timestamp = $_SERVER['REQUEST_TIME'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->port = $_SERVER['SERVER_PORT'];
        $this->protocol = $_SERVER['SERVER_PROTOCOL'];
    }
}
