<?php namespace Controllers;

use Models\Classes\MenuHeader;
use Models\Classes\User;
use Zephyrus\Application\Session;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router;

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
        $exceptions = ["/", "/Connexion/Register"];
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

    public function isLogged(): bool
    {
        return Session::getInstance()->read("isLogged", false);
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