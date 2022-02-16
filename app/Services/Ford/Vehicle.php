<?php

namespace App\Services\Ford;

use GuzzleHttp\Exception\ClientException;

class Vehicle extends Ford
{
    protected array $clientConfig = [
        'base_uri' => 'https://usapi.cv.ford.com',
    ];

    public function status()
    {
        $response = $this->client->get(
            sprintf('https://usapi.cv.ford.com/api/vehicles/v4/%s/status', $this->vin),
            [
                'headers' => array_merge($this->clientHeaders, [
                    'auth-token' => $this->getToken()->access_token,
                ]),
            ]
        );

        return json_decode((string) $response->getBody());
    }

    public function getAll(): array
    {
        $url = 'https://services.cx.ford.com/api/dashboard/v1/users/vehicles';
        $headers = array_merge(
            $this->clientHeaders,
            [
                'Application-Id' => '71A3AD0A-CF46-4CCF-B473-FC7FE5BC4592',
                'Auth-Token' => $this->getToken()->access_token
            ]
        );

        try {
            $response = $this->client->get($url, ['headers' => $headers]);

            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            dd('error : ' . (string) $e->getResponse()->getBody());
        }

        return [];
    }

    /*******************************************
    * Door Control
    *******************************************/

    public function lock()
    {
        $uri = sprintf('api/vehicles/v2/%s/doors/lock', env('FORD_VIN'));
        $headers = array_merge(
            $this->clientHeaders,
            [
                'Application-Id' => '71A3AD0A-CF46-4CCF-B473-FC7FE5BC4592',
                'Auth-Token' => $this->getToken()->access_token
            ]
        );

        $response = $this->client->put($uri, [
            'headers' => $headers
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    public function unlock()
    {
    }

    /*******************************************
    * Engine Control
    *******************************************/

    public function start()
    {
    }

    public function stop()
    {
    }
}
