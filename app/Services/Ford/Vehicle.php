<?php

namespace App\Services\Ford;

class Vehicle extends Ford
{
    protected array $clientConfig = [
        'base_uri' => 'https://usapi.cv.ford.com',
    ];

    public function status(): array
    {
        $response = $this->client->get(
            sprintf('/api/vehicles/v4/%s/status', $this->vin),
            [
                'headers' => $this->headers(),
            ]
        );

        return json_decode((string) $response->getBody(), true);
    }

    /*******************************************
    * Door Control
    *******************************************/

    public function lock(): array
    {
        $uri = sprintf('api/vehicles/v2/%s/doors/lock', $this->vin);
        $response = $this->client->put($uri, [
            'headers' => $this->headers(),
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    public function unlock(): array
    {
        $uri = sprintf('api/vehicles/v2/%s/doors/lock', $this->vin);

        $response = $this->client->delete($uri, [
            'headers' => $this->headers(),
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /*******************************************
    * Engine Control
    *******************************************/

    public function start(): array
    {
        $uri = sprintf('api/vehicles/v2/%s/engine/start', $this->vin);
        $response = $this->client->put($uri, [
            'headers' => $this->headers(),
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    public function stop(): array
    {
        $uri = sprintf('api/vehicles/v2/%s/engine/start', $this->vin);
        $response = $this->client->delete($uri, [
            'headers' => $this->headers(),
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /*******************************************
    * Private methods
    *******************************************/

    private function headers(): array
    {
        return array_merge($this->clientHeaders, [
            'Auth-Token' => $this->getToken()->access_token
        ]);
    }
}
