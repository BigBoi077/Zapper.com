<?php namespace Controllers;

use Models\Brokers\AccountBroker;
use Models\Brokers\TokenBroker;
use Models\Classes\CookieBuilder;
use Models\Classes\FormValidator;
use Models\Classes\Logger;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Session;
use Zephyrus\Network\Response;
use Zephyrus\Security\Cryptography;

class LogInController extends BaseController
{
    public function initializeRoutes()
    {
        $this->get("/", "index");
        $this->post("/", "connect");
        $this->get("/Connexion/Logout", "logout");
    }

    public function index(): Response
    {
        if (!$this->isLogged() xor !$this->hasRememberMeToken()) {
            return $this->redirect("/General/Main");
        }
        return $this->render("/connexion/login", [
            'currentPage' => "Login"
        ]);
    }

    public function connect(): Response
    {
        $broker = new AccountBroker();
        $form = $this->buildForm();
        $user = $broker->getByUsername($form->getValue("username"));
        $validator = new FormValidator($form);
        if (!$validator->isUserValid($user, $form)) {
            Flash::error("Wrong credentials");
            return $this->redirect("/");
        } else {
            $this->setUserSessionInformation($user);
            $userSecret = Cryptography::encrypt($form->getValue("password"), $user->secret);
            if ($form->getValue("remember-me") == "on") {
                $tokenBroker = new TokenBroker();
                $tokenValue = $tokenBroker->insert(sess("id"));
                CookieBuilder::build(CookieBuilder::REMEMBER_ME, $tokenValue);
                CookieBuilder::build(CookieBuilder::USER_SECRET, $userSecret);
            } else {
                Session::getInstance()->set("secret", $userSecret);
            }
            Logger::logUser($user->username);
            return $this->redirect("/General/Main");
        }
    }

    public function logout(): Response
    {
        $broker = new TokenBroker();
        $broker->deleteUserToken(sess("id"));
        CookieBuilder::destroy(CookieBuilder::REMEMBER_ME);
        CookieBuilder::destroy(CookieBuilder::USER_SECRET);
        Session::getInstance()->destroy();
        return $this->redirect("/");
    }
}
