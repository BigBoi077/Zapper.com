<?php namespace Models\Classes;

class Password
{
    private const PASSWORD_PEPPER = "PASSWORD_PEPPER";

    public static function hash(string $password): string
    {
        $passwordPepper = getenv(self::PASSWORD_PEPPER);
        return password_hash($password . $passwordPepper , PASSWORD_DEFAULT);
    }

    public static function verify(string $password): string
    {

    }
}
