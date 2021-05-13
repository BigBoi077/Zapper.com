<?php namespace Controllers;

use Models\Brokers\ServiceBroker;
use Models\Classes\Errors;
use Models\Classes\PasswordManager;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class ServiceController extends BaseController
{
    private string $serviceSalt;

    public function initializeRoutes()
    {
        $this->post("/General/Service/Register", "register");
        $this->post("/General/Service/Modify", "modify");
        $this->post("/General/Service/Remove", "remove");
    }

    public function register()
    {
        $broker = new ServiceBroker();
        $form = $this->buildForm();
        $form->validate("username", Rule::notEmpty(Errors::notEmpty("username")));
        $form->validate("password", Rule::notEmpty(Errors::notEmpty("password")));
        if (!$broker->serviceExist($form->getValue("services"))) {
            $form->addError("service", "Invalid service");
            Flash::error($form->getErrors());
        } else {
            $passwordManager = new PasswordManager();
            $passwordManager->registerUserService($form);
        }
    }

    public function modify()
    {

    }

    public function remove()
    {

    }
}
