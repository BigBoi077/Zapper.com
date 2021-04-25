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
        $validator->checkFields($form);
        if (!$form->verify()) {
            $errors = $form->getErrorMessages();
            Flash::error($errors);
            return $this->render("/connexion/sign-up", [
                'menuItems' => $this->menu->build(),
                'currentPage' => "Sign up",
                'values' => self::emptyArray,
                'flashBox' => "isError"
            ]);
        }
        $this->createUser($form);
        return $this->render("/main/main", [
            'menuItems' => $this->menu->build(),
            'currentPage' => "Websites",
            'values' => self::emptyArray,
            'flashBox' => "isSuccess"
        ]);
    }

    private function createUser(Form $form)
    {
        $broker = new SignUpBroker();
        $user = $this->setUserValues($form);
        $broker->insert($user);
        Flash::success("Votre compte a été créer avec succès");
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
}
