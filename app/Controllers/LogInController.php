<?php namespace Controllers;

use Models\Classes\MenuHeader;
use Zephyrus\Network\Response;

class LogInController extends BaseController
{

    private MenuHeader $menu;

    public function initializeRoutes()
    {
        $this->menu = new MenuHeader();
        $this->get("/", "index");
        $this->get("/Connexion/Login", "index");
        $this->post("/Connexion/Login", "connect");
    }

    public function index(): Response
    {
        return $this->render("/connexion/login", [
            'menuItems' => $this->menu->build(),
            'currentPage' => "Login"
        ]);
    }

    public function connect()
    {

    }
}
