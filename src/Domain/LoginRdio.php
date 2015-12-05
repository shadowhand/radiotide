<?php

namespace Shadowhand\RadioTide\Domain;

use AdamPaterson\OAuth2\Client\Provider\Rdio;
use Spark\Adr\PayloadInterface as Payload;
use Spark\Adr\DomainInterface as Domain;

use Shadowhand\RadioTide\Session;

class LoginRdio implements Domain
{
    /**
     * @var Payload
     */
    private $payload;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var Rdio
     */
    private $rdio;

    public function __construct(
        Payload $payload,
        Session $session,
        Rdio $rdio
    ) {
        $this->payload = $payload;
        $this->session = $session;
        $this->rdio = $rdio;
    }

    private function startLogin()
    {
        $redirect = $this->rdio->getAuthorizationUrl();

        $this->session->set('rdio.state', $this->rdio->getState());

        return $this->payload
            ->withStatus(Payload::OK)
            ->withMessages([
                'redirect' => $redirect,
            ]);
    }

    private function invalidLogin()
    {
        return $this->payload
            ->withStatus(Payload::INVALID)
            ->withOutput([
                'message' => 'Invalid login, please to back and try again',
                'template' => 'error',
            ]);
    }

    private function completeLogin($code)
    {
        $token = $this->rdio->getAccessToken('authorization_code', compact('code'));

        $this->session->del('rdio.state');
        $this->session->set('rdio.token', $token);

        return $this->payload
            ->withStatus(Payload::OK)
            ->withMessages([
                'redirect' => '/login',
            ]);
    }

    public function __invoke(array $input)
    {
        if (empty($input['code'])) {
            return $this->startLogin();
        }

        if (empty($input['state']) || $input['state'] !== $this->session->get('rdio.state')) {
            return $this->invalidLogin();
        }

        return $this->completeLogin($input['code']);
    }
}
