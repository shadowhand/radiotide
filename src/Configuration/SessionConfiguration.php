<?php

namespace Shadowhand\RadioTide\Configuration;

use Auryn\Injector;
use Spark\Configuration\ConfigurationInterface;

use Shadowhand\RadioTide\Session;

class SessionConfiguration implements ConfigurationInterface
{
    public function apply(Injector $injector)
    {
        $injector->prepare(Session::class, function (Session $session) {
            session_set_cookie_params(
                $lifetime = 0,
                $path = '/',
                $domain = '',
                $secure = false,
                $httponly = true
            );
            session_start();
        });

        // Single instance only!
        $injector->share(Session::class);
    }
}
