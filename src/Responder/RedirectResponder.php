<?php

namespace Shadowhand\RadioTide\Responder;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Spark\Adr\PayloadInterface as Payload;
use Spark\Adr\ResponderInterface as Responder;

class RedirectResponder implements Responder
{
    public function __invoke(
        Request $request,
        Response $response,
        Payload $payload
    ) {
        if ($this->hasRedirect($payload)) {
            $messages = $payload->getMessages() + [
                'status' => 302,
            ];

            return $response
                ->withStatus($messages['status'])
                ->withHeader('Location', $messages['redirect']);
        }

        return $response;
    }

    private function hasRedirect(Payload $payload)
    {
        $messages = $payload->getMessages();
        return !empty($messages['redirect']);
    }
}
