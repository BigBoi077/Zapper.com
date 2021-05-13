<?php namespace Controllers;

use Models\Brokers\AccountBroker;
use Models\Brokers\ServiceBroker;
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
        $serviceBroker = new ServiceBroker();
        $services = $serviceBroker->getAllService();
        if ($this->isLogged()) {
            $user = $broker->getById(sess("id"));
        } else {
            $tokeBroker = new TokenBroker();
            $userId = $tokeBroker->getUserIdByToken($_COOKIE[self::REMEMBER_ME]);
            $user = $broker->getById($userId);
        }
        $this->setUserSessionInformation($user);
        //$userServices = $serviceBroker->getUserServices($user);
        return $this->render("/main/main", [
            'user' => $user,
            'services' => $services,
            //'userServices' => $userServices,
            'currentPage' => "Websites",
            'flashBox' => "empty"
        ]);
    }
}