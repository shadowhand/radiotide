<?php

namespace Shadowhand\RadioTide\Configuration;

use Auryn\Injector;
use Spark\Configuration\ConfigurationInterface;
use Spark\Responder\ChainedResponder;

use Shadowhand\RadioTide\Responder\RedirectResponder;

class ResponderConfiguration implements ConfigurationInterface
{
    public function apply(Injector $injector)
    {
        $injector->prepare(ChainedResponder::class, function (ChainedResponder $responder) {
            return $responder->withAddedResponder(RedirectResponder::class);
        });
    }
}
