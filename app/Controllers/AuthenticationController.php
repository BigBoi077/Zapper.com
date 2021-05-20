<?php namespace Controllers;

use Twilio\Rest\Client;

class AuthenticationController extends SecurityController
{
    private const SID = "TWILLIO_ACCOUNT_SID";
    private const TOKEN = "TWILLIO_AUTH_TOKEN";

    public function initializeRoutes()
    {
        $this->post("/Personal/Authentication", "register");
    }

    public function register(): Response
    {
        $account_sid = getenv(self::SID);
        $auth_token = getenv(self::TOKEN);
        $twilio_number = "+14504943201";

        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            '+14504943201',
            array(
                'from' => "The masters of the universe",
                'body' => 'I sent this message in under 10 minutes!'
            )
        );
    }
}
