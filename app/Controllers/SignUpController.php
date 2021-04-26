<?php namespace Controllers;

use Models\Brokers\SignUpBroker;
use Models\Classes\FormValidator;
use Models\Classes\MenuHeader;
use Zephyrus\Application\Flash;
use Models\Classes\User;
use Models\Classes\Password;
use Zephyrus\Application\Form;
use Zephyrus\Application\Session;
use Zephyrus\Security\Cryptography;

class SignUpController extends BaseController
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

    public function insert(): \Zephyrus\Network\Response
    {
        $form = $this->buildForm();
        $validator = new FormValidator();
        $validator->validateSignUpRules($form);
        if ($this->userExists($form->getValue('username'))) {
            Flash::error("Username is already taken");
            if (!$form->verify()) {
                Flash::error($form->getErrorMessages());
            }
            return $this->render("/connexion/sign-up", [
                'menuItems' => $this->menu->build(),
                'currentPage' => "Sign up",
                'values' => $form->getFields(),
                'flashBox' => "isError"
            ]);
        } else {
            $user = $this->createUser($form);
            $this->setUserSessionInformation($user);
            return $this->render("/main/main", [
                'menuItems' => $this->menu->build(),
                'currentPage' => "Websites",
                'flashBox' => "isSuccess",
                'username' => $user->username
            ]);
        }
    }

    private function userExists(string $username): bool
    {
        $broker = new SignUpBroker();
        return $broker->usernameTaken($username);
    }

    private function createUser(Form $form): User
    {
        $broker = new SignUpBroker();
        $user = $this->setUserValues($form);
        $broker->insert($user);
        Flash::success("Your account was created successfully!");
        Session::getInstance()->set("username", $user->username);
        Session::getInstance()->set("id", $user->id);
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
