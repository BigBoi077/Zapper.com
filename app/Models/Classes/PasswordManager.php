<?php namespace Models\Classes;

use JetBrains\PhpStorm\Pure;
use Models\Brokers\ServiceBroker;
use Zephyrus\Application\Form;
use Zephyrus\Application\Session;
use Zephyrus\Security\Cryptography;

class PasswordManager
{
    private ServiceBroker $serviceBroker;
    private string $encryptKey;
    private bool $hasRememberMeToken;

    public function __construct(bool $hasRememberMeToken)
    {
        $this->hasRememberMeToken = $hasRememberMeToken;
        $this->serviceBroker = new ServiceBroker();
        $this->encryptKey = getenv("SERVICE_SALT");
    }

    public function registerUserService(User $user, Form $form)
    {
        $serviceUser = $this->buildUserService($user, $form);
        $this->serviceBroker->insert($serviceUser);
    }

    public function updateUserService(User $user, Form $form)
    {
        $serviceBroker = new ServiceBroker();
        $serviceUser = $this->buildUserService($user, $form);
        $serviceBroker->update($serviceUser);
    }

    public function updateAllUserService(User $user, string $newPassword)
    {
        $allUserServices = $this->serviceBroker->getUserServices($user);
        $allUserServices = $this->decryptServices($allUserServices, $user);
        $this->changeUserSecret($user, $newPassword);
        $derivedKey = Cryptography::deriveEncryptionKey($newPassword, $user->secret);
        foreach ($allUserServices as $service) {
            $service->password = Cryptography::encrypt($service->password, $this->encryptKey);
            $service->password = Cryptography::encrypt($service->password, $derivedKey);
            $service = new ServiceUser(
                $service->id_user,
                $service->id_service,
                $service->username,
                $service->password
            );
            $this->serviceBroker->update($service);
        }
    }

    public function decryptServices(array $userServices, User $user): array
    {
        $authenticator = $this->getAuthenticator($user);
        $derivedKey = Cryptography::deriveEncryptionKey($authenticator, $user->secret);
        foreach ($userServices as $service) {
            $service->password = Cryptography::decrypt($service->password, $derivedKey);
            $service->password = Cryptography::decrypt($service->password, $this->encryptKey);
        }
        return $userServices;
    }

    private function buildUserService(User $user, Form $form): ServiceUser
    {
        $username = $form->getValue("username");
        $password = $form->getValue("password");
        $service = $form->getValue("services");
        $service = $this->serviceBroker->getServiceByName($service);
        $authenticator = $this->getAuthenticator($user);
        $derivedKey = Cryptography::deriveEncryptionKey($authenticator, $user->secret);
        $password = Cryptography::encrypt($password, $this->encryptKey);
        $password = Cryptography::encrypt($password, $derivedKey);
        return new ServiceUser($user->id, $service->id, $username, $password);
    }

    private function getAuthenticator(User $user): ?string
    {
        if ($this->hasRememberMeToken) {
            return Cryptography::decrypt($_COOKIE[CookieBuilder::USER_SECRET], $user->secret);
        } else {
            return Cryptography::decrypt(sess("secret"), $user->secret);
        }
    }

    private function changeUserSecret(User $user, string $newPassword)
    {
        $secret = Cryptography::encrypt($newPassword, $user->secret);
        if ($this->hasRememberMeToken) {
            $_COOKIE[CookieBuilder::USER_SECRET] = $secret;
        } else {
            Session::getInstance()->set("secret", $secret);
        }
    }
}
