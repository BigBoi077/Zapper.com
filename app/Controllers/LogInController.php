<?php namespace Controllers;

use Zephyrus\Network\Response;

class LogInController extends BaseController
{
    public function initializeRoutes()
    {
        $this->get("/", "index");
        $this->post("/Connexion/Login", "connect");
    }

    public function index(): Response
    {
        if ($this->isLogged()) {
            return $this->redirect("/General/Main");
        }
        return $this->render("/connexion/login", [
            'currentPage' => "Login"
        ]);
    }

    public function connect()
    {

    }
}
