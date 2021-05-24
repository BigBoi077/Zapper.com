<?php namespace Controllers;

class EmailController extends BaseController
{

    public function initializeRoutes()
    {
        $this->get("/Connexion/Authentication/Email", "handleEmail");
        $this->post("/Connexion/Authentication/Email/Connect", "connectByEmail");
    }
}
