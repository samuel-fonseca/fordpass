<?php

namespace App\Services\Ford;

use App\Models\Token as ModelsToken;
use GuzzleHttp\Client;

class Ford
{
    protected string $username;

    protected string $password;

    protected string $vin;

    protected Client $client;

    protected $client_id = '9fb503e0-715b-47e8-adfd-ad4b7770f73b';

    protected array $clientConfig = [];

    protected array $clientHeaders = [
        'Accept' => '*/*',
        'Accept-Language' => 'en-us',
        'Content-Type' => 'application/json',
        'User-Agent' => 'FordPass/5 CFNetwork/1197 Darwin/20.0.00',
        'Accept-Encoding' => 'gzip, deflate, br',
        'Application-Id' => '71A3AD0A-CF46-4CCF-B473-FC7FE5BC4592',
    ];

    public function __construct()
    {
        $this->username = env('FORD_USERNAME');
        $this->password = env('FORD_PASSWORD');
        $this->vin = env('FORD_VIN');

        $this->client = new Client($this->clientConfig);
    }

    public function getToken(): ModelsToken
    {
        $token = ModelsToken::query()->notExpired()->first();

        if (empty($token)) {
            $token = (new Token)->authenticate();
        }

        return $token;
    }
}
