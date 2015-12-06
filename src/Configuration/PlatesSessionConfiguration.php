<?php

namespace Shadowhand\RadioTide\Configuration;

use Auryn\Injector;
use Spark\Configuration\ConfigurationInterface;
use League\Plates\Engine;

use Shadowhand\RadioTide\Session;

class PlatesSessionConfiguration implements ConfigurationInterface
{
    public function apply(Injector $injector)
    {
        $injector->prepare(Engine::class, function (Engine $engine) use ($injector) {
            $session = $injector->make(Session::class);

            $engine->registerFunction('is_logged_in', function () use ($session) {
                return $session->has('rdio.token')
                    && $session->has('tidal.session');
            });
        });
    }
}
