<?php

namespace Shadowhand\RadioTide\Configuration;

use Auryn\Injector;
use Spark\Configuration\ConfigurationInterface;
use Spark\Router;

use Shadowhand\RadioTide\Domain\Login;
use Shadowhand\RadioTide\Domain\LoginRdio;
use Shadowhand\RadioTide\Domain\LoginTidal;
use Shadowhand\RadioTide\Domain\Import;

class RoutingConfiguration implements ConfigurationInterface
{
    public function apply(Injector $injector)
    {
        $injector->prepare(Router::class, function (Router $router) {
            $router->get('/', Import::class);
            $router->get('/login', Login::class);
            $router->get('/login/rdio', LoginRdio::class);
            $router->get('/login/tidal', LoginTidal::class);
            $router->post('/login/tidal', LoginTidal::class);
        });
    }
}
