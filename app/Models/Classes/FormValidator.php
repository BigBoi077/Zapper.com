<?php namespace Models\Classes;

use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class FormValidator
{

    public function checkFields(Form $form)
    {
        $form->validate('firstname', Rule::notEmpty(Errors::notEmpty("firstname")));
        $form->validate('lastname', Rule::notEmpty(Errors::notEmpty("lastname")));
        $form->validate('email', Rule::email(Errors::incorrectFormat("email")));
        $form->validate('phone', Rule::phone(Errors::incorrectFormat("phone")));
        $form->validate('username', Rule::regex(Regex::$username, "A username must be between 5 to 31 characters, have at least a capital letter and a number"));
        $form->validate('password', Rule::passwordCompliant("A password must be a least 8 characters, have at least a capital letter, a number and a symbol"));
    }
}
