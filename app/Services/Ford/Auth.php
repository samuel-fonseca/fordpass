<?php

namespace App\Services\Ford;

use App\Models\Token as ModelsToken;
use App\Services\Ford\Exceptions\FordpassException;
use App\Services\Parsers\DomParser;
use App\Services\Parsers\QueryParser;
use Exception;
use GuzzleHttp\Exception\ClientException;

class Auth extends Ford
{
    protected string $username;

    protected string $password;

    protected array $challenge = [];

    protected string $redirectUrl = 'fordapp://userauthorized';

    protected $client_id = '9fb503e0-715b-47e8-adfd-ad4b7770f73b';

    private string $url = 'https://sso.ci.ford.com/oidc/endpoint/default/token';

    public function authenticate(): ModelsToken
    {
        $this->challenge = $this->getChallengeCode();
        $session = $this->attemptLogin();

        $headers = $this->clientHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
        ]);
        $body = [
            'client_id' => $this->client_id,
            'grant_type' => 'authorization_code',
            'code' => $session['code'],
            'grant_id' => $session['grant_id'],
            'code_verifier' => $this->challenge['code_verifier'],
            'scope' => 'openid',
            'redirect_uri' => $this->redirectUrl,
        ];

        try {
            $response = $this->client->post($this->url, [
                'headers' => $headers,
                'form_params' => $body
            ]);
        } catch (ClientException $e) {
            throw new FordpassException($e->getMessage());
        }

        return $this->saveToken(json_decode((string) $response->getBody(), true));
    }

    protected function initWebSession(): ?array
    {
        try {
            $response = $this->client->get('https://sso.ci.ford.com/v1.0/endpoint/default/authorize', [
                'query' => [
                    'redirect_uri' => $this->redirectUrl,
                    'response_type' => 'code',
                    'scope' => 'openid',
                    'max_age' => 3600,
                    'client_id' => $this->client_id,
                    'code_challenge' => $this->challenge['code_challenge'].'%3D',
                    'code_challenge_method' => 'S256',
                ],
                'headers' => $this->clientHeaders(['accept' => 'text/html; charset=utf-8']),
                'allow_redirects' => ['strict' => false],
            ]);

            $url = 'https://sso.ci.ford.com';
            $nextCookies = $response->getHeader('Set-Cookie') ?? [];

            if ($response->getStatusCode() === 200) {
                $parser = new DomParser((string) $response->getBody());
                $d = $parser->findByClass('ibm-ci-data-container');
                $url .= $parser->getAttribute($d->item(0), 'data-ibm-login-url');

                return [
                    'url' => $url,
                    'cookies' => $nextCookies,
                ];
            }
        } catch (ClientException $e) {
            throw new FordpassException($e->getMessage());
        }
    }

    protected function attemptLogin(): array
    {
        $session = $this->initWebSession();
        $url = $session['url'] ?? null;
        $cookies = $session['cookies'] ?? null;

        $body = [
            'operation' => 'verify',
            'login-form-type' => 'pwd',
            'username' => $this->username,
            'password' => $this->password,
        ];
        $headers = $this->clientHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Cookie' => $cookies,
        ]);

        try {
            $response = $this->client->post($url, [
                'headers' => $headers,
                'allow_redirects' => false,
                'form_params' => $body,
            ]);

            if ($response->getStatusCode() === 302 && $response->getHeader('Location')) {
                return $this->fetchAuthorizationCode(
                    $response->getHeader('Location')[0],
                    (array) $response->getHeader('Set-Cookie') ?? []
                );
            }
        } catch (ClientException $e) {
            throw new FordpassException($e->getMessage());
        }

        return [];
    }

    protected function fetchAuthorizationCode(string $url, array $cookies)
    {
        try {
            $response = $this->client->get($url, [
                'headers' => $this->clientHeaders([
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Cookie' => $cookies,
                ]),
                'allow_redirects' => false,
            ]);

            if ($response->getStatusCode() === 302 && $response->getHeader('Location')) {
                $query = new QueryParser($response->getHeader('Location')[0]);

                return [
                    'code' => $query->find('code'),
                    'grant_id' => $query->find('grant_id'),
                ];
            }
        } catch (ClientException $e) {
            throw new FordpassException($e->getMessage());
        }
    }

    protected function getChallengeCode(): array
    {
        try {
            $response = $this->client->post('https://fpw-pkce-svc-2.herokuapp.com/getchallenge');
            $body = json_decode($response->getBody()->getContents(), true);

            return [
                'code_verifier' => $body['code_verifier'] ?? null,
                'code_challenge' => $body['code_challenge'] ?? null,
            ];
        } catch (ClientException $e) {
            throw new FordpassException('Could not get challenge code...');
        }
    }

    protected function saveToken(array $response): ModelsToken
    {
        $token = ModelsToken::firstOrNew([
            'access_token' => $response['access_token'] ?? null,
            'refresh_token' => $response['refresh_token'] ?? null,
            'scope' => $response['scope'] ?? null,
            'grant_id' => $response['grant_id'] ?? null,
            'id_token' => $response['id_token'] ?? null,
            'token_type' => $response['token_type'] ?? null,
            'expires_in' => $response['expires_in'] ?? null,
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
