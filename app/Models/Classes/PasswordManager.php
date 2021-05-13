<?php namespace Models\Classes;

use Zephyrus\Application\Form;
use Zephyrus\Security\Cryptography;

class PasswordManager
{
    public function registerUserService(Form $form)
    {
        $username = $form->getValue("username");
        $password = $form->getValue("password");
        $service = $form->getValue("service");
        $encryptKey = getenv("SERVICE_SALT");
        $derivedKey = Cryptography::deriveEncryptionKey("allo123", "salf_user");
        $password = Cryptography::encrypt($password, $encryptKey);
        $password = Cryptography::encrypt($password, $derivedKey);
    }
}
