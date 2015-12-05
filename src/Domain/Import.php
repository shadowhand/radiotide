<?php

namespace Shadowhand\RadioTide\Domain;

use Shadowhand\RadioTide\Domain;
use Spark\Adr\PayloadInterface as Payload;

class Import extends Domain
{
    public function __invoke(array $input)
    {
        $output = [];

        return $this->payload
            ->withStatus(Payload::OK)
            ->withOutput($output + [
                'template' => 'import',
            ]);
    }
}
