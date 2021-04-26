<?php namespace Controllers;

use Models\Brokers\AccountBroker;
use Models\Classes\MenuHeader;
use Zephyrus\Application\Session;

class MainController extends BaseController
{
    private MenuHeader $menu;

    public function initializeRoutes()
    {
        $this->menu = new MenuHeader();
        $this->get("/General/Main", "index");
    }

    public function index()
    {
        $broker = new AccountBroker();
        if (Session::getInstance()->has("id")) {
            $user = $broker->getById(Session::getInstance()->read("id"));
        }
        return $this->render("/main/main", [
            'menuItems' => $this->menu->build(),
            'currentPage' => "Websites",
            'flashBox' => "empty",
        ]);
    }
}