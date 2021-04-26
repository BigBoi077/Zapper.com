<?php namespace Controllers;

use \Zephyrus\Application\Session;

class AccountController extends BaseController
{

    public function initializeRoutes()
    {
        $this->get("/Personal/Account", "index");
    }

    public function index()
    {
        $this->render("account/personal", [
            'currentPage' => "Account",
            'flashBox' => "empty",
            'username' => Session::getInstance()->read("username", "Jace")
        ]);
    }
}
