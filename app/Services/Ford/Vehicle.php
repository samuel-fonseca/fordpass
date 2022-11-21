<?php

namespace App\Services\Ford;

class Vehicle extends Ford
{
    protected array $clientConfig;

    protected string $application_id = '71A3AD0A-CF46-4CCF-B473-FC7FE5BC4592';

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

        $response = $this->client->get(sprintf('/api/vehicles/v5/%s/status', $this->vin));

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
                ->get(sprintf('/api/users/vehicles/%s/detail', $this->vin))
        );
    }

    public function listAll(bool $fresh = false): array
    {
        if ($fresh) {
            $this->refreshStatus();
        }

        $response = $this->client->post('https://api.mps.ford.com/api/expdashboard/v1/details');

        return $this->decodedResponse($response);
    }

    /*******************************************
    * Door Control
    *******************************************/

    public function lock(): array
    {
        $uri = sprintf('api/vehicles/v5/%s/doors/lock', $this->vin);
        $response = $this->client->put($uri, [
            'headers' => $this->headers(),
        ]);

        return $this->decodedResponse($response);
    }

    public function unlock(): array
    {
        $uri = sprintf('api/vehicles/v5/%s/doors/lock', $this->vin);

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
        $token = $this->getToken();

        return array_merge($this->clientHeaders, [
            'Content-Type' => 'application/json',
            'Accept' => '*/*',
            'Accept-Language' => 'en-US,en;q=0.9',
            'Application-Id' => $this->application_id,
            'auth-token' => $token->access_token,
            'Referer' => 'https://ford.com',
            'Origin' => 'https://ford.com',
        ]);
    }

    private function refreshStatus(): array
    {
        $response = $this->client->put(sprintf('/api/vehicles/%s/status', $this->vin));

        return $this->decodedResponse($response);
    }
}
