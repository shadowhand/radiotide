<?php

namespace Shadowhand\RadioTide\Domain;

use AdamPaterson\OAuth2\Client\Provider\Rdio;
use GuzzleHttp\Exception\ServerException;
use JmesPath;
use Spark\Adr\PayloadInterface as Payload;
use Spark\Adr\DomainInterface as Domain;

use Shadowhand\RadioTide\Session;
use Shadowhand\RadioTide\TidalClient as Tidal;

class Import implements Domain
{
    /**
     * @var Payload
     */
    private $payload;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var Rdio
     */
    private $rdio;

    /**
     * @var Tidal
     */
    private $tidal;

    public function __construct(
        Payload $payload,
        Session $session,
        Rdio $rdio,
        Tidal $tidal
    ) {
        $this->payload = $payload;
        $this->session = $session;
        $this->rdio = $rdio;
        $this->tidal = $tidal;
    }

    private function callRdio($method, array $body = [])
    {
        $uri = 'https://services.rdio.com/api/1/' . $method;

        $token = $this->session->get('rdio.token');

        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'body' => http_build_query(array_replace($body, compact('method'))),
        ];

        $request = $this->rdio->getAuthenticatedRequest('POST', $uri, $token, $options);
        $response = $this->rdio->getResponse($request);

        return $response;
    }

    private function getRdioCollection()
    {
        $method = 'getAlbumsInCollection';
        $body = [
            'extras' => json_encode([
                ['field' => '*', 'exclude' => true],
                ['field' => 'artist'],
                ['field' => 'name'],
            ]),
        ];

        $response = $this->callRdio($method, $body);

        return JmesPath\search('result[*]', $response);
    }

    private function getRdioFavorites()
    {
        $method = 'getFavorites';
        $body = [
            'types' => 'tracksAndAlbums',
            'extras' => json_encode([
                ['field' => '*', 'exclude' => true],
                ['field' => 'artist'],
                ['field' => 'name'],
            ]),
        ];

        $response = $this->callRdio($method, $body);

        return JmesPath\search('result[*]', $response);
    }

    private function searchTidal($query)
    {
        $session = $this->session->get('tidal.session');
        $query = [
            'query' => $query,
            'sessionId' => $session['sessionId'],
            'countryCode' => $session['countryCode'],
            'limit' => 10,
            'types' => 'ALBUMS,TRACKS',
        ];

        $response = $this->tidal->body(
            $this->tidal->get('search', compact('query'))
        );

        return JmesPath\search('albums.items[*].{id:id,name:title,artist:artists[0].name}', $response);
    }

    private function addTidalFav($albumId)
    {
        $session = $this->session->get('tidal.session');

        $path = sprintf('users/%d/favorites/albums', $session['userId']);

        $query = [
            'sessionId' => $session['sessionId'],
            'countryCode' => $session['countryCode'],
        ];

        $form_params = compact('albumId');

        return $this->tidal->post($path, compact('query', 'form_params'));
    }

    private function addTidalFavs(array $collection)
    {
        $count = 0;
        foreach ($collection as $album) {
            $query = $album['artist'] . ' ' . $album['name'];
            $found = $this->searchTidal($query);

            if (empty($found)) {
                $missing[] = $query;
                continue;
            }

            $id = array_shift($found)['id'];

            try {
                $this->addTidalFav($id);
            } catch (ServerException $e) {
                if (!$e->hasResponse() || !$this->tidal->isProbablyDuplicate($e->getResponse())) {
                    $missing[] = $query;
                    continue;
                }
            }

            $count++;
        }

        return [$count, $missing];
    }

    private function importRdioCollection()
    {
        return $this->addTidalFavs($this->getRdioCollection());
    }

    private function importRdioFavorites()
    {
        return $this->addTidalFavs($this->getRdioFavorites());
    }

    public function __invoke(array $input)
    {
        $types = [
            'collection' => 'importRdioCollection',
            'favorites' => 'importRdioFavorites',
        ];

        if (!empty($input['types'])) {
            $wants = $input['types'];
            if (!is_array($wants)) {
                $wants = preg_split('/,\s*/', $wants);
            }
            $types = array_intersect_key($types, array_flip($wants));
        }

        $missing = 0;
        $imported = 0;

        $failed = [];
        foreach ($types as $type => $method) {
            list ($i, $m) = call_user_func([$this, $method]);

            $failed[$type] = $m;

            $imported += $i;
            $missing += count($m);
        }

        $output = compact('imported', 'missing', 'failed');

        return $this->payload
            ->withStatus(Payload::OK)
            ->withOutput($output + [
                'template' => 'imported',
            ]);
    }
}
