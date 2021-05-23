<?php namespace Models\Classes;

use Models\Brokers\AccountBroker;
use Zephyrus\Application\Form;

class AuthenticationManager
{
    private User $user;
    private Form $form;
    private array $choices;
    private array $messages;
    private bool $userChangedAuth;

    public function __construct(User $user, Form $form)
    {
        $this->user = $user;
        $this->form = $form;
        $this->userChangedAuth = false;
        $this->choices = [
            ["name" => 'sms', "fullName" => "verification by text", "value" => 1],
            ["name" => "email", "fullName" => "verification by mail", "value" => 2],
            ["name" => "googleAuth", "fullName" => "verification by Google Authenticator", "value" => 4]
        ];
        $this->messages = array();
    }

    public function activateUserAuthentications()
    {
        foreach ($this->choices as $item) {
            if ($this->form->getValue($item["name"]) != null) {
                $this->activateAuthentication($item);
            } else {
                $this->removeAuthentication($item);
            }
        }
        $this->updateUserAuthentication();
    }

    public function userChangedAuthentication(): bool
    {
        return $this->userChangedAuth;
    }

    public function getMessages(): string
    {
        $wholeMessage = "";
        foreach ($this->messages as $message) {
            $wholeMessage .= $message . "\n";
        }
        return $wholeMessage;
    }

    private function activateAuthentication(array $item)
    {
        if ($this->wasActivated($item)) {
            return;
        }
        $this->user->authentication += $item["value"];
        $this->addMessage($item["fullName"]);
    }

    private function removeAuthentication(array $item)
    {
        if ($this->userActivated($item["value"])) {
            $this->user->authentication -= $item["value"];
        }
    }

    private function addMessage(string $fullName)
    {
        array_push($this->messages, "Activated $fullName");
    }

    private function userActivated(int $value): bool
    {
        return $this->user->authentication & $value;
    }

    private function updateUserAuthentication()
    {
        $accountBroker = new AccountBroker();
        $accountBroker->update($this->user);
    }

    private function wasActivated(array $item): bool
    {
        return $this->user->authentication & $item["value"];
    }
}
