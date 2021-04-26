<?php namespace Controllers;

use Models\Brokers\SignUpBroker;
use Models\Classes\FormValidator;
use Models\Classes\MenuHeader;
use Zephyrus\Application\Flash;
use Models\Classes\User;
use Models\Classes\Password;
use Zephyrus\Application\Form;

class SignUpController extends SecurityController
{
    private MenuHeader $menu;
    private const emptyArray = [ 'firstname' => '', 'lastname' => '', 'username' => '', 'phone' => '', 'email' => '' ];

    public function initializeRoutes()
    {
        $this->menu = new MenuHeader();
        $this->get("/Connexion/Register", "index");
        $this->post("/Connexion/Register", "insert");
    }

    public function index()
    {
        return $this->render("/connexion/sign-up", [
            'menuItems' => $this->menu->build(),
            'currentPage' => "Sign up",
            'values' => self::emptyArray,
            'flashBox' => "empty"
        ]);
    }

    public function insert()
    {
        $form = $this->buildForm();
        $validator = new FormValidator();
        $validator->validateSignUpRules($form);
        if (!$form->verify()) {
            $errors = $form->getErrorMessages();
            Flash::error($errors);
            return $this->render("/connexion/sign-up", [
                'menuItems' => $this->menu->build(),
                'currentPage' => "Sign up",
                'values' => $form->getFields(),
                'flashBox' => "isError"
            ]);
        } else {
            $user = $this->createUser($form);
            return $this->render("/main/main", [
                'menuItems' => $this->menu->build(),
                'currentPage' => "Websites",
                'flashBox' => "isSuccess",
                'username' => $user->username
            ]);
        }
    }

    private function createUser(Form $form): User
    {
        $broker = new SignUpBroker();
        $user = $this->setUserValues($form);
        $broker->insert($user);
        Flash::success("Votre compte a été créer avec succès");
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
        $user->password = Password::hash($form->getValue("firstname"));
        return $user;
    }

    private function returnToSignUp(Form $form)
    {
        return $this->render("/connexion/sign-up", [
            'menuItems' => $this->menu->build(),
            'currentPage' => "Sign up",
            'values' => $form->getFields(),
            'flashBox' => "isError"
        ]);
    }
}
