<?php

namespace Shadowhand\RadioTide;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class TidalClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $token;

    /**
     * @param string $token
     */
    public function __construct(Client $client, $token)
    {
        $this->client = $client;
        $this->token = $token;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return array
     */
    public function login($username, $password)
    {
        $options = [
            'form_params' => compact('username', 'password'),
        ];

        $response = $this->post('login/username', $options);

        return $this->body($response);
    }

    /**
     * @param string $path
     * @param array $options
     *
     * @return Response
     */
    public function get($path, array $options = [])
    {
        return $this->client->request('GET', $this->uri($path), $this->options($options));
    }

    /**
     * @param string $path
     * @param array $options
     *
     * @return Response
     */
    public function post($path, array $options = [])
    {
        return $this->client->request('POST', $this->uri($path), $this->options($options));
    }

    /**
     * @param string $path
     * @param array $options
     *
     * @return Response
     */
    public function delete($path, array $options = [])
    {
        return $this->client->request('DELETE', $this->uri($path), $this->options($options));
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function uri($path)
    {
        return 'https://api.tidalhifi.com/v1/' . $path;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    private function options(array $options)
    {
        $options['query']['token'] = $this->token;

        return $options;
    }

    /**
     * @return mixed
     */
    public function body(Response $response)
    {
        $type = $response->getHeaderLine('Content-Type');

        if (false === strpos($type, 'application/json')) {
            throw new \RuntimeException(sprintf(
                'Invalid response type `%s` detected',
                $type
            ));
        }

        $body = (string) $response->getBody();

        return json_decode($body);
    }
}
