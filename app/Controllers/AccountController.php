<?php namespace Controllers;

use Models\Brokers\AccountBroker;
use Models\Brokers\TokenBroker;
use Zephyrus\Network\Response;
use Zephyrus\Utilities\Gravatar;

class AccountController extends BaseController
{

    public function initializeRoutes()
    {
        $this->get("/Personal/Account", "index");
        $this->post("/Personal/Account/Change", "alter");
    }

    public function index(): Response
    {
        $accountBroker = new AccountBroker();
        $user = $accountBroker->getById(sess("id"));
        $tokenBroker = new TokenBroker();
        $tokens = $tokenBroker->getTokensById(sess("id"));
        $gravatar = new Gravatar(sess("email"));
        return $this->render("/account/personal", [
            'currentPage' => "Account",
            'user' => $user,
            "tokens" => $tokens,
            'gravatar' => $gravatar->getUrl()
        ]);
    }

    public function alter()
    {

    }
}
