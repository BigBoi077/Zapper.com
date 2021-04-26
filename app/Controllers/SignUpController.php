<?php namespace Controllers;

use Models\Brokers\SignUpBroker;
use Models\Classes\FormValidator;
use \Zephyrus\Network\Response;
use Zephyrus\Application\Flash;
use Models\Classes\User;
use Zephyrus\Application\Form;
use Zephyrus\Application\Session;
use Zephyrus\Security\Cryptography;

class SignUpController extends BaseController
{
    private const emptyArray = [ 'firstname' => '', 'lastname' => '', 'username' => '', 'phone' => '', 'email' => '' ];

    public function initializeRoutes()
    {
        $this->get("/Connexion/Register", "index");
        $this->post("/Connexion/Register", "insert");
    }

    public function index(): Response
    {
        return $this->render("/connexion/sign-up", [
            'currentPage' => "Sign up",
            'values' => self::emptyArray,
        ]);
    }

    public function insert(): Response
    {
        $form = $this->buildForm();
        $validator = new FormValidator($form);
        $validator->validateSignUpRules();

        if (!$form->verify()) {
            Flash::error($form->getErrorMessages());
            return $this->redirect("/Connexion/Register");
        } else {
            $user = $this->createUser($form);
            $this->setUserSessionInformation($user);
            return $this->redirect("/General/Main");
        }
    }

    private function createUser(Form $form): User
    {
        $broker = new SignUpBroker();
        $user = $this->setUserValues($form);
        $broker->insert($user);
        $this->setUserSessionInformation($user);
        Flash::success("Your account was created successfully!");
        Session::getInstance()->set("isLogged", true);
        return $user;
    }

    private function setUserValues(Form $form): User
    {
        $user = new User();
        $user->username = $form->getValue("username");
        $user->firstname = $form->getValue("firstname");
        $user->lastname = $form->getValue("lastname");
        $user->phone = $form->getValue("phone");
        $user->email = $form->getValue("email");
        $user->password = Cryptography::hashPassword($form->getValue("password"));
        return $user;
    }
}
