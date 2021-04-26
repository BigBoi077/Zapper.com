<?php namespace Controllers;

use Models\Brokers\AccountBroker;
use Models\Classes\FormValidator;
use Zephyrus\Application\Flash;
use Zephyrus\Network\Response;

class LogInController extends BaseController
{
    public function initializeRoutes()
    {
        $this->get("/", "index");
        $this->post("/", "connect");
        $this->post("Connexion/Logout", "logout");
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
        if ($validator->same) {
            Flash::error("Wrong credentials");
            return $this->redirect("/Connexion/Register");
        } else {
            $user =
            $this->setUserSessionInformation($user);
            return $this->redirect("/General/Main");
        }
    }
}
