<?php

namespace Shadowhand\RadioTide\Domain;

use Spark\Adr\PayloadInterface as Payload;
use Spark\Adr\DomainInterface as Domain;

use Shadowhand\RadioTide\Session;

class Logout implements Domain
{
    /**
     * @var Payload
     */
    private $payload;

    /**
     * @var Session
     */
    private $session;

    public function __construct(
        Payload $payload,
        Session $session
    ) {
        $this->payload = $payload;
        $this->session = $session;
    }

    public function __invoke(array $input)
    {
        $this->session->del('rdio.token');
        $this->session->del('tidal.session');

        return $this->payload
            ->withStatus(Payload::OK)
            ->withMessages([
                'redirect' => 'login',
            ]);
    }
}
