<?php namespace Controllers;

use Models\MenuHeader;

class ConnexionController extends SecurityController
{

    private MenuHeader $menu;

    public function initializeRoutes()
    {
        $this->menu = new MenuHeader();
        $this->get("/", "index");
        $this->get("/Connexion/Login", "index");
        $this->get("/Connexion/Register", "register");
    }

    public function index() {
        return $this->render("/connexion/login", [
            'menuItems' => $this->menu->build(),
            'currentPage' => "Login"
        ]);
    }

    public function register() {
        return $this->render("/connexion/sign-up", [
            'menuItems' => $this->menu->build(),
            'currentPage' => "Sign up"
        ]);
    }
}
