<?php


namespace Controllers;


use Models\Brokers\TokenBroker;
use Models\Classes\TwilioService;
use \Zephyrus\Application\Session;
use Zephyrus\Network\Response;
use Zephyrus\Security\Cryptography;

class SecondFactorAuthenticationController extends BaseController
{
    private const SMS_BITWISE = 1;
    private const EMAIL_BITWISE = 2;
    private const GOOGLE_AUTH_BITWISE = 4;

    public function initializeRoutes()
    {
        $this->get("/Connexion/Authentication", "index");
    }

    public function index(): Response
    {
        $userBitwiseValue = sess("authentication");
        if ($userBitwiseValue & self::SMS_BITWISE) {
            Session::getInstance()->set("needsNewCode", true);
            return $this->redirect("/Connexion/Authentication/SMS");
        }
        if ($userBitwiseValue & self::EMAIL_BITWISE) {
            Session::getInstance()->set("needsNewCode", true);
            return $this->redirect("/Connexion/Authentication/Email");
        }
    }
}