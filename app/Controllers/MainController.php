<?php namespace Controllers;

use Models\Classes\MenuHeader;

class MainController extends SecurityController
{
    private MenuHeader $menu;

    public function initializeRoutes()
    {
        $this->menu = new MenuHeader();
        $this->get("/Zapper/Main", "index");
    }

    public function index()
    {
        return $this->render("/main/main", [
            'menuItems' => $this->menu->build(),
            'currentPage' => "Sign up"
        ]);
    }
}