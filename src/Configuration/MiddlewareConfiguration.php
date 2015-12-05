<?php

namespace Shadowhand\RadioTide\Configuration;

use Auryn\Injector;
use Spark\Configuration\ConfigurationInterface;
use Spark\Handler\RouteHandler;
use Spark\Middleware\DefaultCollection;
use Spark\Middleware\Collection;

use Shadowhand\RadioTide\Middleware\CheckSessionMiddleware;

class MiddlewareConfiguration implements ConfigurationInterface
{
    public function apply(Injector $injector)
    {
        $injector->alias(Collection::class, DefaultCollection::class);

        $injector->prepare(Collection::class, function (Collection $collection) {
            $middleware = $collection->getArrayCopy();

            // Do session checking before routing
            array_splice(
                $middleware,
                array_search(RouteHandler::class, $middleware),
                0,
                CheckSessionMiddleware::class
            );

            $collection->exchangeArray($middleware);
        });
    }
}
