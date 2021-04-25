<?php namespace Controllers;

use Models\MenuHeader;

class LogInController extends SecurityController
{

    private MenuHeader $menu;

    public function initializeRoutes()
    {
        $this->menu = new MenuHeader();
        $this->get("/", "index");
        $this->get("/Connexion/Login", "index");
    }

    public function index() {
        return $this->render("/connexion/login", [
            'menuItems' => $this->menu->build(),
            'currentPage' => "Login"
        ]);
    }
}
