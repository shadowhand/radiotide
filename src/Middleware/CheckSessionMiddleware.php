<?php

namespace Shadowhand\RadioTide\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Shadowhand\RadioTide\Session;

class CheckSessionMiddleware
{
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Check if services are available
     *
     * @return boolean
     */
    private function isReady()
    {
        return $this->session->has('rdio.token')
            && $this->session->has('tidal.session');
    }

    /**
     * Check if the request is for login
     *
     * @return boolean
     */
    private function isLoginRequest(Request $request)
    {
        return false !== strpos(trim($request->getUri()->getPath(), '/'), 'login');
    }

    public function __invoke(Request $request, Response $response, callable $next)
    {
        if ($this->isReady() || $this->isLoginRequest($request)) {
            return $next($request, $response);
        }

        return $response
            ->withStatus(302)
            ->withAddedHeader('Location', '/login');
    }
}
