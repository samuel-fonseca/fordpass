<?php

namespace App\Services\Ford;

class Vehicle extends Ford
{
    protected array $clientConfig;

    public function __construct()
    {
        $this->clientConfig = [
            'base_uri' => 'https://usapi.cv.ford.com',
            'headers' => $this->headers(),
        ];

        parent::__construct();
    }

    public function status(bool $fresh = false): array
    {
        if ($fresh) {
            $this->refreshStatus();
        }

        $response = $this->client->get(sprintf('/api/vehicles/v4/%s/status', $this->vin));

        return $this->decodedResponse($response);
    }

    public function capabilities(): array
    {
        return $this->decodedResponse(
            $this->client
                ->get(sprintf('https://api.mps.ford.com/api/capability/v1/vehicles/%s', $this->vin))
        );
    }

    public function details(): array
    {
        return $this->decodedResponse(
            $this->client
                ->get(sprintf('https://usapi.cv.ford.com/api/users/vehicles/%s/detail', $this->vin))
        );
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

        return $this->decodedResponse($response);
    }

    public function unlock(): array
    {
        $uri = sprintf('api/vehicles/v2/%s/doors/lock', $this->vin);

        $response = $this->client->delete($uri, [
            'headers' => $this->headers(),
        ]);

        return $this->decodedResponse($response);
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

        return $this->decodedResponse($response);
    }

    public function stop(): array
    {
        $uri = sprintf('api/vehicles/v2/%s/engine/start', $this->vin);
        $response = $this->client->delete($uri, [
            'headers' => $this->headers(),
        ]);

        return $this->decodedResponse($response);
    }

    /*******************************************
    * Guard Mode
    *******************************************/

    public function guard(): array
    {
        $uri = sprintf('https://api.mps.ford.com/api/guardmode/v1/%s/session', $this->vin);
        $response = $this->client->put($uri, [
            'headers' => $this->headers(),
        ]);

        return $this->decodedResponse($response);
    }

    public function unguard(): array
    {
        $uri = sprintf('https://api.mps.ford.com/api/guardmode/v1/%s/session', $this->vin);
        $response = $this->client->delete($uri, [
            'headers' => $this->headers(),
        ]);

        return $this->decodedResponse($response);
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

    private function refreshStatus(): array
    {
        $response = $this->client->put(sprintf('/api/vehicles/%s/status', $this->vin));

        return $this->decodedResponse($response);
    }
}
