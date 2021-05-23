<?php namespace Controllers;

use Models\Brokers\AccountBroker;
use Models\Brokers\ServiceBroker;
use Models\Brokers\TokenBroker;
use Models\Classes\CookieBuilder;
use Models\Classes\Logger;
use Models\Classes\PasswordManager;
use Models\Classes\User;
use phpDocumentor\Reflection\DocBlock\Tags\Formatter\PassthroughFormatter;
use Zephyrus\Application\Session;
use Zephyrus\Network\Response;
use Zephyrus\Security\Cryptography;

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
        $passwordManager = new PasswordManager($this->hasRememberMeToken());
        $serviceBroker = new ServiceBroker();
        $services = $serviceBroker->getAllService();
        if ($this->isLogged()) {
            $user = $broker->getById(sess("id"));
        } else {
            $tokeBroker = new TokenBroker();
            $userId = $tokeBroker->getUserIdByToken($_COOKIE[CookieBuilder::REMEMBER_ME]);
            $user = $broker->getById($userId);
        }
        $this->setUserSessionInformation($user);
        $userServices = $serviceBroker->getUserServices($user);
        if (!empty($userServices)) {
            $userServices = $passwordManager->decryptServices($userServices, $user);
        }
        return $this->render("/main/main", [
            'user' => $user,
            'services' => $services,
            'userServices' => $userServices,
            'currentPage' => "Websites",
            'flashBox' => "empty"
        ]);
    }
}