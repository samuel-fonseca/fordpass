<?php

namespace App\Services\Ford;

use App\Models\Token as ModelsToken;

class Token extends Ford
{
    protected string $username;

    protected string $password;

    protected $client_id = '9fb503e0-715b-47e8-adfd-ad4b7770f73b';

    private string $url = 'https://sso.ci.ford.com/oidc/endpoint/default/token';

    public function authenticate(): ModelsToken
    {
        $headers = array_merge($this->clientHeaders, [
            'authorization' => 'Basic ZWFpLWNsaWVudDo=',
        ]);

        $token = $this->requestOAuthToken();
        $response = $this->client->put('https://api.mps.ford.com/api/oauth2/v1/token', [
            'headers' => $headers,
            'json' => [
                'code' => $token['access_token']
            ],
        ]);

        return $this->saveToken(json_decode((string) $response->getBody(), true));
    }

    public function requestOAuthToken(): array
    {
        $headers = array_merge($this->clientHeaders, [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]);
        $body = [
            'client_id' => $this->client_id,
            'grant_type' => 'password',
            'username' => $this->username,
            'password' => $this->password,
        ];

        $response = $this->client->post($this->url, [
            'headers' => $headers,
            'form_params' => $body
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    protected function saveToken(array $response): ModelsToken
    {
        $token = ModelsToken::firstOrNew([
            'access_token' => $response['access_token'] ?? null,
            'refresh_token' => $response['refresh_token'] ?? null,
            'cat1_token' => $response['cat1_token'] ?? null,
            'user_id' => $response['user_id'] ?? null,
            'expires_at' => (int) ($response['expires_in'] ?? 0),
            'refresh_expires_at' => (int) ($response['refresh_expires_at'] ?? 0),
        ]);

        if (! $token->exists) {
            $token->save();
        }

        return $token;
    }
}
