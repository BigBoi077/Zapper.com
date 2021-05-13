<?php namespace Models\Classes;

class ServiceUser
{
    public int $userId;
    public int $serviceId;
    public String $username;
    public String $password;

    public function __construct(string $userId, int $serviceId, string $username, string $password)
    {
        $this->userId = $userId;
        $this->serviceId = $serviceId;
        $this->username = $username;
        $this->password = $password;
    }
}
