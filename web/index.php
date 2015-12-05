<?php

if (php_sapi_name() === 'cli-server'
    && preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER['REQUEST_URI'])
) {
    // For compatability with PHP SAPI
    return false;
}

// Check for deployment configuration
$env = __DIR__ . '/../.env';

if (!is_file($env)) {
    echo 'Missing .env configuration! Please run the following:' . PHP_EOL
       . PHP_EOL
       . 'cp example.env .env && $EDITOR .env'
       . PHP_EOL;
    exit(1);
}

// Include Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

use Auryn\Injector;
use josegonzalez\Dotenv\Loader as EnvLoader;
use Spark\Configuration\DefaultConfigurationSet;
use Spark\Configuration\PlatesResponderConfiguration;

use Shadowhand\RadioTide\Configuration\MiddlewareConfiguration;
use Shadowhand\RadioTide\Configuration\ResponderConfiguration;
use Shadowhand\RadioTide\Configuration\RoutingConfiguration;
use Shadowhand\RadioTide\Configuration\SessionConfiguration;

// Load deployment configuration
$config = (new EnvLoader($env))->parse()->toArray();

// Configure the dependency injection container
$injector = new Injector;

// Set the template directory for Plates
$injector->define('League\Plates\Engine', [
    ':directory' => realpath(__DIR__ . '/../templates'),
]);

// Set configuration for Rdio OAuth
$injector->define('AdamPaterson\OAuth2\Client\Provider\Rdio', [
    ':options' => [
        'clientId' => $config['rdio_client_id'],
        'clientSecret' => $config['rdio_client_secret'],
        'redirectUri' => Shadowhand\RadioTide\get_server_url() . '/login/rdio',
    ],
]);

// Set configuration for Tidal API
$injector->define('Shadowhand\RadioTide\TidalClient', [
    ':token' => $config['tidal_token'],
]);

// Apply additional configuration
(new DefaultConfigurationSet([
    MiddlewareConfiguration::class,
    PlatesResponderConfiguration::class,
    ResponderConfiguration::class,
    RoutingConfiguration::class,
    SessionConfiguration::class,
]))->apply($injector);

// Bootstrap the application
call_user_func(
    $injector->make('Relay\Relay'),
    $injector->make('Psr\Http\Message\ServerRequestInterface'),
    $injector->make('Psr\Http\Message\ResponseInterface')
);
