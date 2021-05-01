<?php namespace Controllers;

use Models\Brokers\AccountBroker;
use Zephyrus\Application\Session;
use Zephyrus\Network\Response;

class MainController extends BaseController
{

    public function initializeRoutes()
    {
        $this->get("/General/Main", "index");
    }

    public function index(): Response
    {
        $broker = new AccountBroker();
        $user = $broker->getById(sess("id"));
        return $this->render("/main/main", [
            'user' => $user,
            'currentPage' => "Websites",
            'flashBox' => "empty",
        ]);
    }
}