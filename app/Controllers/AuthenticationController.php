<?php namespace Controllers;

use Models\Brokers\AccountBroker;
use Models\Classes\AuthenticationManager;
use Models\Classes\Errors;
use Models\Classes\PasswordManager;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Rule;
use \Zephyrus\Network\Response;
use Zephyrus\Security\Cryptography;

class AuthenticationController extends BaseController
{
    public function initializeRoutes()
    {
        $this->post("/Personal/Security/Password", "alterPassword");
        $this->post("/Personal/Security/Authentication", "activateSecondFactorAuthentication");
    }

    public function alterPassword(): Response
    {
        $accountBroker = new AccountBroker();
        $passwordManager = new PasswordManager($this->hasRememberMeToken());
        $form = $this->buildForm();
        $user = $accountBroker->getById(sess("id"));
        $oldPassword = $form->getValue("oldPassword");
        $newPassword = $form->getValue("newPassword");
        $form->validate('oldPassword', Rule::notEmpty(Errors::notEmpty("old password")));
        $form->validate('newPassword', Rule::notEmpty(Errors::notEmpty("new password")));
        $form->validateWhenFieldHasNoError('newPassword', Rule::passwordCompliant(Errors::incorrectFormat("new password")));
        if ($form->verify()) {
            if (!Cryptography::verifyHashedPassword($oldPassword, $user->password)) {
                Flash::error("The old password did not match your current password");
                return $this->redirect("/Personal/Account");
            } else {
                $passwordManager->updateAllUserService($user, $newPassword);
                $accountBroker->updatePassword($user->id, Cryptography::hashPassword($newPassword));
                Flash::success("Successfully changed your password");
                return $this->redirect("/General/Main");
            }
        } else {
            Flash::error($form->getErrorMessages());
            return $this->redirect("/Personal/Account");
        }
    }

    public function activateSecondFactorAuthentication(): Response
    {
        $accountBroker = new AccountBroker();
        $user = $accountBroker->getById(sess("id"));
        $authenticator = new AuthenticationManager($user, $this->buildForm());
        $authenticator->activateUserAuthentications();
        if ($authenticator->userChangedAuthentication()) {
            Flash::success($authenticator->getMessages());
        }
        return $this->redirect("/General/Main");
    }
}
