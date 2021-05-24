<?php namespace Controllers;

class GoogleAuthController extends BaseController
{

    public function initializeRoutes()
    {
        $this->get("/Connexion/Authentication/GoogleAuthenticator", "handleGoogleAuth");
        $this->post("/Connexion/Authentication/GoogleAuthenticator/Connect", "ConnectByGoogleAuth");
    }
}
