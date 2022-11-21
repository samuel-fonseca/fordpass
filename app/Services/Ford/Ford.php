<?php

namespace App\Services\Ford;

use App\Models\Token as ModelsToken;
use GuzzleHttp\Client;

class Ford
{
    protected string $vin;

    protected Client $client;

    protected array $clientConfig = [];

    protected array $clientHeaders = [
        'Accept' => '*/*',
        'User-Agent' => 'FordPass/24 CFNetwork/1399 Darwin/22.1.0',
        'Accept-Language' => 'en-US,en;q=0.9',
        'Accept-Encoding' => 'gzip, deflate, br',
    ];

    public function __construct()
    {
        $this->username = env('FORD_USERNAME');
        $this->password = env('FORD_PASSWORD');
        $this->vin = env('FORD_VIN');

        $this->client = new Client($this->clientConfig);
    }

    public function vin(string $vin): static
    {
        $this->vin = $vin;

        return $this;
    }

    public function getToken(): ModelsToken
    {
        $token = ModelsToken::query()->notExpired()->first();

        if (empty($token)) {
            $token = (new Auth())->authenticate();
        }

        return $token;
    }

    public function getVehicles(): array
    {
        $url = 'https://services.cx.ford.com/api/dashboard/v1/users/vehicles';
        $headers = $this->clientHeaders + [
            'Auth-Token' => $this->getToken()->access_token
        ];
        $response = $this->client->get($url, ['headers' => $headers]);

        return $this->decodedResponse($response);
    }

    protected function decodedResponse(mixed $response): mixed
    {
        return json_decode((string) $response->getBody(), true);
    }

    protected function clientHeaders(?array $headers = null): array
    {
        return array_merge(
            $this->clientHeaders,
            $headers ?? []
        );
    }
}
