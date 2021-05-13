<?php namespace Models\Classes;

use Models\Brokers\ServiceBroker;
use Zephyrus\Application\Form;
use Zephyrus\Security\Cryptography;

class PasswordManager
{
    public function registerUserService(User $user, Form $form, bool $hasRememberMeToken)
    {
        $serviceBroker = new ServiceBroker();
        $username = $form->getValue("username");
        $password = $form->getValue("password");
        $service = $form->getValue("services");
        $service = $serviceBroker->getServiceByName($service);
        $encryptKey = getenv("SERVICE_SALT");
        if ($hasRememberMeToken) {
            $authenticator = Cryptography::decrypt($_COOKIE[CookieBuilder::USER_SECRET], $user->secret);
        } else {
            $authenticator = Cryptography::decrypt(sess("secret"), $user->secret);
        }
        $derivedKey = Cryptography::deriveEncryptionKey($authenticator, $user->secret);
        $password = Cryptography::encrypt($password, $encryptKey);
        $password = Cryptography::encrypt($password, $derivedKey);
        $serviceUser = new ServiceUser($user->id, $service->id, $username, $password);
        $serviceBroker->insert($serviceUser);
    }
}
