<?php namespace Models\Classes;

class User
{
    public int $id;
    public String $firstname;
    public String $lastname;
    public String $username;
    public String $email;
    public String $phone;
    public String $password;

    public function __construct(\stdClass $result = null)
    {
        if (is_null($result)) {
            return;
        }
        $this->id = $result->id;
        $this->lastname = $result->lastname;
        $this->firstname = $result->firstname;
        $this->username = $result->username;
        $this->email = $result->email;
        $this->phone = $result->phone;
        $this->password = $result->password;
    }
}
