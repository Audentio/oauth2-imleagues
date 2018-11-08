<?php

namespace Audentio\OAuth2\Client\IMLeagues\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class IMLeagues extends AbstractProvider
{
    public $apiDomain = 'https://api.imleagues.com';

    public $scopes = ['iml.user'];

    public function getBaseAuthorizationUrl()
    {
        return $this->apiDomain . '/OAuth/Authorize.aspx';
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->apiDomain . '/OAuth/Token.ashx';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->apiDomain . '/me';
    }

    protected function getDefaultScopes()
    {
        return [
            'iml.user',
        ];
    }

    public function getHeaders($token = null)
    {
        $headers = [];
        if (!$token) {
            $auth = base64_encode($this->clientId . ':' . $this->clientSecret);
            $headers['Authorization'] = 'Basic ' . $auth;
        }

        $headers = array_merge(parent::getHeaders($token), $headers);

        return $headers;
    }

    protected function getAccessTokenOptions(array $params)
    {
        if (isset($params['client_id'])) {
            unset($params['client_id']);
            unset($params['client_secret']);
        }

        return parent::getAccessTokenOptions($params);
    }

    protected function getAuthorizationHeaders($token = null)
    {
        /** @var AccessToken $token */

        if ($token) {
            return [
                'Authorization' => 'Bearer ' . $token->getToken(),
            ];
        }

        return [];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() !== 200) {
            throw new IdentityProviderException(
                null,
                $response->getStatusCode(),
                $response
            );
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new IMLeaguesUser($response);
    }

}
