<?php namespace Controllers;

use Models\Classes\MenuHeader;
use \Zephyrus\Application\Session;

class AccountController extends SecurityController
{
    private MenuHeader $menu;

    public function initializeRoutes()
    {
        $this->menu = new MenuHeader();
        $this->get("/Personal/Account", "index");
    }

    public function index()
    {
        $this->render("account/personal", [
            'menuItems' => $this->menu->build(),
            'currentPage' => "Account",
            'flashBox' => "empty",
            'username' => Session::getInstance()->read("username", "Jace")
        ]);
    }
}
