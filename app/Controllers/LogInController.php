<?php namespace Controllers;

use Models\Brokers\AccountBroker;
use Models\Classes\FormValidator;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Session;
use Zephyrus\Network\Response;

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
        if ($this->isLogged()) {
            return $this->redirect("/General/Main");
        }
        return $this->render("/connexion/login", [
            'currentPage' => "Login"
        ]);
    }

    public function connect(): Response
    {
        $form = $this->buildForm();
        $broker = new AccountBroker();
        $user = $broker->getByUsername($form->getValue("username"));
        $validator = new FormValidator($form);
        if (!$validator->isUserValid($user, $form)) {
            Flash::error("Wrong credentials");
            return $this->redirect("/");
        } else {
            $this->setUserSessionInformation($user);
            return $this->redirect("/General/Main");
        }
    }

    public function logout(): Response
    {
        Session::getInstance()->destroy();
        return $this->redirect("/");
    }
}
