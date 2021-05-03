<?php namespace Controllers;

use Models\Brokers\AccountBroker;
use Models\Brokers\TokenBroker;
use Models\Classes\Errors;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Rule;
use Zephyrus\Network\Response;
use Zephyrus\Utilities\Gravatar;

class AccountController extends BaseController
{

    public function initializeRoutes()
    {
        $this->get("/Personal/Account", "index");
        $this->post("/Personal/Account/Change", "alter");
    }

    public function index(): Response
    {
        $accountBroker = new AccountBroker();
        $user = $accountBroker->getById(sess("id"));
        $tokenBroker = new TokenBroker();
        $tokens = $tokenBroker->getTokensById(sess("id"));
        $gravatar = new Gravatar(sess("email"));
        return $this->render("/account/personal", [
            'currentPage' => "Account",
            'user' => $user,
            "tokens" => $tokens,
            'gravatar' => $gravatar->getUrl()
        ]);
    }

    public function alter(): Response
    {
        $form = $this->buildForm();
        $form->validate('firstname', Rule::notEmpty(Errors::notEmpty("firstname")));
        $form->validate('lastname', Rule::notEmpty(Errors::notEmpty("lastname")));
        $form->validate('email', Rule::notEmpty(Errors::notEmpty("email")));
        $form->validate('phone', Rule::notEmpty(Errors::notEmpty("phone")));
        $form->validateWhenFieldHasNoError('email', Rule::email(Errors::incorrectFormat("email")));
        $form->validateWhenFieldHasNoError('phone', Rule::phone(Errors::incorrectFormat("phone")));
        if ($form->verify()) {
            Flash::success("Credentials were changed successfully!");
            $accountBroker = new AccountBroker();
            $user = $accountBroker->getById(sess("id"));
            $user->firstname = $form->getValue("firstname");
            $user->lastname = $form->getValue("lastname");
            $user->email = $form->getValue("email");
            $user->phone = $form->getValue("phone");
            $accountBroker->update($user);
        } else {
            Flash::error($form->getErrors());
        }
        return $this->redirect("/Personal/Account");
    }
}
