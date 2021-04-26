<?php namespace Models\Classes;

use Models\Brokers\SignUpBroker;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;
use Zephyrus\Security\Cryptography;

class FormValidator
{
    private Form $form;

    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    public function validateSignUpRules()
    {
        $this->form->validate('firstname', Rule::notEmpty(Errors::notEmpty("firstname")));
        $this->form->validate('lastname', Rule::notEmpty(Errors::notEmpty("lastname")));
        $this->form->validate('email', Rule::email(Errors::incorrectFormat("email")));
        $this->form->validate('phone', Rule::phone(Errors::incorrectFormat("phone")));
        $this->form->validate('username', Rule::regex(Regex::$username, "A username must be between 5 to 31 characters, have at least a capital letter and a number"));
        $this->form->validate('password', Rule::passwordCompliant("A password must be a least 8 characters, have at least a capital letter, a number and a symbol"));
        $this->form->validateWhenFieldHasNoError('username', new Rule(function ($value) {
            $broker = new SignUpBroker();
            return !$broker->usernameTaken($value);
        }, "Username is already taken"));
    }

    public function isUserValid(User $user, Form $form): bool
    {
        if (!isset($user->password)) {
            return false;
        }
        $clearTextPassword = $form->getValue("password");
        return !(Cryptography::verifyHashedPassword($clearTextPassword, $user->password)
            && strcmp($form->getValue("username"), $user->username));
    }
}
