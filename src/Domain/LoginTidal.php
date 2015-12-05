<?php

namespace Shadowhand\RadioTide\Domain;

use Spark\Adr\PayloadInterface as Payload;
use Spark\Adr\DomainInterface as Domain;

use Shadowhand\RadioTide\Session;
use Shadowhand\RadioTide\TidalClient as Tidal;

class LoginTidal implements Domain
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
     * @var Tidal
     */
    private $tidal;

    public function __construct(
        Payload $payload,
        Session $session,
        Tidal $tidal
    ) {
        $this->payload = $payload;
        $this->session = $session;
        $this->tidal = $tidal;
    }

    private function completeLogin($username, $password)
    {
        $session = $this->tidal->login($username, $password);

        $this->session->set('tidal.session', $session);

        return $this->payload
            ->withStatus(Payload::OK)
            ->withMessages([
                'redirect' => '/login',
            ]);
    }

    private function isValidEmail($username)
    {
        return filter_var($username, FILTER_VALIDATE_EMAIL);
    }

    private function invalidLogin($username)
    {
        return $this->payload
            ->withStatus(Payload::INVALID)
            ->withMessages([
                'username' => 'Must be a valid email address',
            ])
            ->withOutput([
                'template' => 'login/tidal',
            ]);
    }

    public function __invoke(array $input)
    {
        if (!empty($input['username']) && !empty($input['password'])) {
            if (!$this->isValidEmail($input['username'])) {
                return $this->invalidLogin($input['username']);
            }

            return $this->completeLogin($input['username'], $input['password']);
        }

        return $this->payload
            ->withStatus(Payload::OK)
            ->withOutput([
                'template' => 'login/tidal',
            ]);
    }
}
