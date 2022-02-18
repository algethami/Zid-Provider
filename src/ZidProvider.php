<?php

namespace Algethami\Zid;

use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class ZidProvider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'ZID';

    protected $stateless = true;

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://oauth.zid.sa/oauth/authorize', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://oauth.zid.sa/oauth/token';
    }

    /**
     * Get the access token response for the given code.
     *
     * @param  string  $code
     * @return array
     */
    public function getAccessTokenResponse($code)
    {
        return \Http::acceptJson()
            ->post($this->getTokenUrl(), $this->getTokenFields($code))
            ->json();
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        abort_if(empty($token), 400);

        return \Http::acceptJson()
            ->withToken($this->credentialsResponseBody['authorization'])
            ->withHeaders([
                "X-MANAGER-TOKEN"   => $this->credentialsResponseBody['access_token'],
            ])
            ->get('https://api.zid.sa/v1/managers/account/profile')
            ->json();
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['user']['id'],
            'nickname' => $user['user']['username'],
            'name' => $user['user']['name'],
            'email' => $user['user']['email'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code'
        ]);
    }
}
