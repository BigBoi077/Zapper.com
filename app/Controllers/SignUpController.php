<?php namespace Controllers;

use Models\MenuHeader;

class SignUpController extends SecurityController
{

    private MenuHeader $menu;

    public function initializeRoutes()
    {
        $this->menu = new MenuHeader();
        $this->get("/Connexion/Register", "index");
        $this->post("/Connexion/Register", "insert");
    }

    public function index() {
        return $this->render("/connexion/sign-up", [
            'menuItems' => $this->menu->build(),
            'currentPage' => "Sign up"
        ]);
    }

    public function insert() {

    }
}
