<?php

namespace Shadowhand\RadioTide\Domain;

use Spark\Adr\PayloadInterface as Payload;
use Spark\Adr\DomainInterface as Domain;

use Shadowhand\RadioTide\Session;

class Login implements Domain
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
        return $this->payload
            ->withStatus(Payload::OK)
            ->withOutput([
                'rdio_ready' => $this->session->has('rdio.token'),
                'tidal_ready' => $this->session->has('tidal.session'),
                'template' => 'login',
            ]);
    }
}
