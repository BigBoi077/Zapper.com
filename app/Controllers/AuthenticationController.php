<?php namespace Controllers;

use Models\Brokers\AccountBroker;
use Models\Classes\Errors;
use Models\Classes\PasswordManager;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Rule;
use \Zephyrus\Network\Response;
use Twilio\Rest\Client;
use Zephyrus\Security\Cryptography;

class AuthenticationController extends BaseController
{
    private const SID = "TWILIO_ACCOUNT_SID";
    private const TOKEN = "TWILIO_AUTH_TOKEN";
    private const PHONE = "TWILIO_PHONE_NUMBER";

    public function initializeRoutes()
    {
        $this->post("/Personal/Security/Password", "passwordAlter");
        $this->post("/Personal/Security/Authentication", "activate");
    }

    public function passwordAlter(): Response
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

    public function sendSMS()
    {
        $account_sid = getenv(self::SID);
        $auth_token = getenv(self::TOKEN);
        $twilio_number = getenv(self::PHONE);

        var_dump($account_sid);

        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            '+14504943201',
            array(
                'from' => $twilio_number,
                'body' => 'Here is your verification code'
            )
        );
    }

    private function updateSecret()
    {
    }
}
