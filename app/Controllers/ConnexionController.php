<?php namespace Controllers;

class ConnexionController extends SecurityController
{
    private array $menuItems = ["Login", "Register", "Websites", "Account"];

    public function initializeRoutes()
    {
        $this->get("/Connexion/Login", "index");
        $this->get("/Connexion/Register", "register");
    }

    public function index() {
        return $this->render("/connexion/login", [
            'menuItems' => $this->menuItems,
            'currentPage' => "Login"
        ]);
    }

    public function register() {
        return $this->render("/connexion/sign-up", [
            'menuItems' => $this->menuItems,
            'currentPage' => "Sign up"
        ]);
    }
}
