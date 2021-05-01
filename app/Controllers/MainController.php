<?php namespace Controllers;

use Models\Brokers\AccountBroker;
use Models\Brokers\TokenBroker;
use Models\Classes\User;
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
        $user = new User();
        if ($this->isLogged()) {
            $user = $broker->getById(sess("id"));
        } else {
            $tokeBroker = new TokenBroker();
            $userId = $tokeBroker->getUserIdByToken($_COOKIE[self::REMEMBER_ME]);
            $user = $broker->getById($userId);
        }
        $this->setUserSessionInformation($user);
        return $this->render("/main/main", [
            'user' => $user,
            'currentPage' => "Websites",
            'flashBox' => "empty",
        ]);
    }
}