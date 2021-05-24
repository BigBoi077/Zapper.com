<?php namespace Controllers;

use Models\Brokers\TokenBroker;
use Models\Classes\CookieBuilder;
use Models\Classes\MenuHeader;
use Models\Classes\User;
use Zephyrus\Application\Session;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router;
use Zephyrus\Security\Cryptography;

abstract class BaseController extends SecurityController
{
    protected MenuHeader $menu;

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->menu = new MenuHeader();
    }

    public function before(): ?Response
    {
        $exceptions = ["/", "/Connexion/Register", $this->hasRememberMeToken()];
        if (!in_array($this->request->getRoute(), $exceptions) && !$this->isLogged()) {
            return $this->redirect("/");
        }
        return parent::before();
    }

    public function render($page, $args = []): Response
    {
        return parent::render($page, array_merge($args, [
            'menuItems' => $this->menu->build(),
        ]));
    }

    protected function isLogged(): bool
    {
        return Session::getInstance()->read("isLogged", false);
    }

    protected function isVerified(User $user)
    {
        if ($user->authentication == 0) {
            return true;
        }
        if (Session::getInstance()->has("isVerified")) {
            return sess("isVerified");
        }
        return false;
    }

    protected function hasRememberMeToken(): bool
    {
        $broker = new TokenBroker();
        if (!isset($_COOKIE[CookieBuilder::REMEMBER_ME])) {
            return false;
        }
        return $broker->tokenExist($_COOKIE[CookieBuilder::REMEMBER_ME]);
    }

    public function setUserSessionInformation(User $user)
    {
        Session::getInstance()->set("id", $user->id);
        Session::getInstance()->set("name", "$user->firstname $user->lastname");
        Session::getInstance()->set("username", $user->username);
        Session::getInstance()->set("email", $user->email);
        Session::getInstance()->set("phone", $user->phone);
        Session::getInstance()->set("authentication", $user->authentication);
        Session::getInstance()->set("isLogged", true);
    }
}