<?php

namespace app\modules\user\components\oauth;

use OAuth\OAuth2\Service\ServiceInterface;

/**
 * LinkedIn provider class.
 *
 * @package application.extensions.eauth.services
 */
class LinkedinOAuth2Service extends \nodge\eauth\oauth2\Service
{

    /**
     * Defined scopes
     *
     * @link http://developer.linkedin.com/documents/authentication#granting
     */
    const SCOPE_R_BASICPROFILE = 'r_basicprofile';
    const SCOPE_R_FULLPROFILE = 'r_fullprofile';
    const SCOPE_R_EMAILADDRESS = 'r_emailaddress';
    const SCOPE_R_NETWORK = 'r_network';
    const SCOPE_R_CONTACTINFO = 'r_contactinfo';
    const SCOPE_RW_NUS = 'rw_nus';
    const SCOPE_RW_GROUPS = 'rw_groups';
    const SCOPE_W_MESSAGES = 'w_messages';

    protected $name = 'linkedin_oauth2';
    protected $title = 'LinkedIn';
    protected $type = 'OAuth2';
    protected $jsArguments = ['popup' => ['width' => 900, 'height' => 550]];

    protected $scopes = [self::SCOPE_R_EMAILADDRESS];
    protected $providerOptions = [
        'authorize' => 'https://www.linkedin.com/uas/oauth2/authorization',
        'access_token' => 'https://www.linkedin.com/uas/oauth2/accessToken',
    ];
    protected $baseApiUrl = 'https://api.linkedin.com/v1/';

    protected function fetchAttributes()
    {
        $this->getAccessTokenData();
        $info = $this->makeSignedRequest('people/~:(id,first-name,last-name,public-profile-url,email-address)', [
            'query' => [
                'format' => 'json',
            ],
        ]);

        $this->attributes['id'] = $info['id'];
        $this->attributes['first_name'] = $info['firstName'];
        $this->attributes['last_name'] = $info['lastName'];
        $this->attributes['email'] = $info['emailAddress'];

        return true;
    }

    /**
     * @return int
     */
    public function getAuthorizationMethod()
    {
        return ServiceInterface::AUTHORIZATION_METHOD_QUERY_STRING_V2;
    }
}