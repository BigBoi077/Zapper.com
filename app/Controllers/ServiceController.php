<?php namespace Controllers;

use Models\Brokers\AccountBroker;
use Models\Brokers\ServiceBroker;
use Models\Classes\Errors;
use Models\Classes\PasswordManager;
use Models\Classes\User;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Rule;
use Zephyrus\Network\Response;

class ServiceController extends BaseController
{
    private string $serviceSalt;

    public function initializeRoutes()
    {
        $this->post("/General/Service/Register", "register");
        $this->post("/General/Service/Modify", "modify");
        $this->post("/General/Service/Remove", "remove");
    }

    public function register(): Response
    {
        $serviceBroker = new ServiceBroker();
        $userBroker = new AccountBroker();
        $user = new User();
        $user = $userBroker->getById(sess("id"));
        $form = $this->buildForm();
        $form->validate("username", Rule::notEmpty(Errors::notEmpty("username")));
        $form->validate("password", Rule::notEmpty(Errors::notEmpty("password")));
        if (!$serviceBroker->serviceExist($form->getValue("services")) && $form->verify()) {
            $form->addError("service", "Invalid service");
            Flash::error($form->getErrors());
        } else {
            $passwordManager = new PasswordManager();
            $passwordManager->registerUserService($user, $form, $this->hasRememberMeToken());
        }
        return $this->redirect("/General/Main");
    }

    public function modify()
    {

    }

    public function remove()
    {
        $serviceBroker = new ServiceBroker();
        $form = $this->buildForm();
        $service = $form->getValue("service");
        if (!$serviceBroker->serviceExist($service)) {
            return $this->redirect("/General/Main");
        }
        $userId = sess("id");
        $serviceId = $serviceBroker->getAccordingIdForService($service);
        $serviceBroker->delete($userId, $serviceId);
        Flash::success("Deleted your $service credentials successfully");
        return $this->redirect("/General/Main");
    }
}
