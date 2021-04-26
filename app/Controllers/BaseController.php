<?php namespace Controllers;

use Models\Classes\User;
use Zephyrus\Application\Session;

class BaseController extends SecurityController
{
    private const DEFAULT_VALUE = "Default";

    public function isLogged(): bool
    {
        if (Session::getInstance()->has("isLogged")) {
            return Session::getInstance()->read("isLogged") == true;
        }
        return false;
    }

    public function initializeRoutes()
    {
        if ($this->isLogged()) {
            $this->redirect("/General/Main");
        }
        $this->redirect("/Connexion/Login");
    }

    public function getSessionValue(string $value): string
    {
        if (Session::getInstance()->has($value)) {
            return Session::getInstance()->read($value);
        }
        return self::DEFAULT_VALUE;
    }

    public function setUserSessionInformation(User $user)
    {
        Session::getInstance()->set("id", $user->id);
        Session::getInstance()->set("name", "$user->firstname $user->lastname");
        Session::getInstance()->set("username", $user->username);
        Session::getInstance()->set("email", $user->email);
        Session::getInstance()->set("phone", $user->phone);
    }
}