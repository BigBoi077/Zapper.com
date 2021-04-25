<?php namespace Models\Brokers;

use stdClass;

class SignUpBroker extends Broker
{
    function insert(stdClass $user)
    {
        $form = $this->buildForm();

    }
}
