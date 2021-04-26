<?php namespace Controllers;

use Models\Classes\MenuHeader;
use Models\Classes\User;
use Zephyrus\Application\Session;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router;

abstract class BaseController extends SecurityController
{
    private const DEFAULT_VALUE = "Default";
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

    /**
     * Override example of the render method to automatically include arguments to be sent to any views for any
     * Controller class extending this middleware. Useful for global data used in layout files.
     *
     * @param string $page
     * @param array $args
     * @return Response
     */
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