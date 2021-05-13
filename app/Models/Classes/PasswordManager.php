<?php namespace Models\Classes;

use Zephyrus\Application\Form;
use Zephyrus\Network\Cookie;
use Zephyrus\Security\Cryptography;

class PasswordManager
{
    public function registerUserService(User $user, Form $form, bool $hasRememberMeToken)
    {
        $username = $form->getValue("username");
        $password = $form->getValue("password");
        $service = $form->getValue("service");
        $encryptKey = getenv("SERVICE_SALT");
        if ($hasRememberMeToken) {
            $authenticator = Cryptography::decrypt($_COOKIE[CookieBuilder::USER_SECRET], $user->secret);
        } else {
            $authenticator = Cryptography::decrypt(sess("secret"), $user->secret);
        }
        $derivedKey = Cryptography::deriveEncryptionKey($authenticator, $user->secret);
        $password = Cryptography::encrypt($password, $encryptKey);
        $password = Cryptography::encrypt($password, $derivedKey);
    }
}
