<?php namespace Controllers;

use Models\Brokers\TokenBroker;
use Models\Classes\TwilioService;
use Twig\Token;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Session;
use Zephyrus\Network\Response;
use Zephyrus\Security\Cryptography;

class SMSController extends BaseController
{

    public function initializeRoutes()
    {
        $this->get("/Connexion/Authentication/SMS", "index");
        $this->post("/Connexion/Authentication/SMS/Verify", "verify");
    }

    public function index(): Response
    {
        Session::getInstance()->set("currentAuthenticationPage", "/Connexion/Authentication/SMS");
        if (sess("needsNewCode")) {
            $twilio = new TwilioService();
            $tokenBroker = new TokenBroker();
            $verificationCode = Cryptography::randomInt(100000, 999999);
            $tokenBroker->insertSMSToken(sess("id"), $verificationCode);
            $twilio->sendSMSVerificationCode($verificationCode, sess("phone"));
        }
        return $this->render("/connexion/sms", [
            'phoneNumber' => sess("phone")
        ]);
    }

    public function verify(): Response
    {
        $tokenBroker = new TokenBroker();
        $form = $this->buildForm();
        $numbers = $form->getValue("code");
        $fullCode = "";
        foreach ($numbers as $number) {
            $fullCode .= $number;
        }
        if (is_numeric($fullCode)) {
            if ($tokenBroker->exists($fullCode)) {
                var_dump("TOKEN REAL");
                $id = $tokenBroker->getUserIdBySMSToken($fullCode);
                if ($id == sess("id")) {
                    Session::getInstance()->set("isVerified", true);
                    $tokenBroker->deleteSMSToken($fullCode);
                    return $this->redirect("/General/Main");
                }
            }
        }
        Session::getInstance()->set("needsNewCode", false);
        return $this->redirect(sess("currentAuthenticationPage"));
    }
}
