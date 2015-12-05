<?php

namespace Shadowhand\RadioTide\Domain;

use Spark\Adr\PayloadInterface as Payload;
use Spark\Adr\DomainInterface as Domain;

class Choose implements Domain
{
    /**
     * @var Payload
     */
    private $payload;

    public function __construct(
        Payload $payload
    ) {
        $this->payload = $payload;
    }

    public function __invoke(array $input)
    {
        return $this->payload
            ->withStatus(Payload::OK)
            ->withOutput([
                'template' => 'import',
            ]);
    }
}
