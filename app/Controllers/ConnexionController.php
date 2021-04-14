<?php namespace Controllers;

class ConnexionController extends SecurityController
{
    private array $menuItems = ["Login", "Register", "Websites", "Account"];

    public function initializeRoutes()
    {
        // Todo : faire un href et un nom pour le header (faire un classe PHP)
        $this->get("/", "index");
        $this->get("/Login", "index");
        $this->get("/Register", "register");
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
