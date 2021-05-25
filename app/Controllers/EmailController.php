<?php namespace Controllers;

use Models\Brokers\TokenBroker;
use Models\Classes\EmailService;
use Zephyrus\Application\Session;
use Zephyrus\Network\Response;
use Zephyrus\Security\Cryptography;

class EmailController extends BaseController
{

    public function initializeRoutes()
    {
        $this->get("/Connexion/Authentication/Email", "handleEmail");
        $this->get("/Connexion/Authentication/Email/Connect", "connectByEmail");
    }

    public function handleEmail(): Response
    {
        Session::getInstance()->set("currentAuthenticationPage", "/Connexion/Authentication/Email");
        if (sess("needsNewCode")) {
            $tokenBroker = new TokenBroker();
            $emailService = new EmailService();
            $tokenValue = Cryptography::randomString(64);
            $tokenBroker->insertEmailToken(sess("id"), $tokenValue);
            $emailService->sendEmail(sess("email"), $tokenValue);
        }
        return $this->render("/connexion/email", [
            'userEmail' => sess('email')
        ]);
    }

    public function connectByEmail(): Response
    {
        $tokenBroker = new TokenBroker();
        $token = $_GET['token'];
        if ($tokenBroker->emailTokenExists($token)) {
            $id = $tokenBroker->getUserIdByEmailToken($token);
            if ($id == sess("id")) {
                Session::getInstance()->set("isVerified", true);
                $tokenBroker->deleteEmailToken($token);
                return $this->redirect("/General/Main");
            }
        }
        return $this->redirect("/");
    }
}
