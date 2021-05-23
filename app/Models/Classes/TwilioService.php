<?php namespace Models\Classes;

use Twilio\Rest\Client;

class TwilioService
{
    private const SID = "TWILIO_ACCOUNT_SID";
    private const TOKEN = "TWILIO_AUTH_TOKEN";
    private const PHONE = "TWILIO_PHONE_NUMBER";

    public function sendSMSVerificationCode(int $code, string $userPhoneNumber)
    {
        $account_sid = getenv(self::SID);
        $auth_token = getenv(self::TOKEN);
        $twilio_number = getenv(self::PHONE);
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            $userPhoneNumber,
            array(
                'from' => $twilio_number,
                'body' => "Your verification code for Zapper is : $code"
            )
        );
    }
}
