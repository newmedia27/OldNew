<?php

namespace app\modules\user\components\oauth;

class FacebookOAuth2Service extends \nodge\eauth\services\extended\FacebookOAuth2Service
{
    protected $scopes = [
        self::SCOPE_EMAIL,
    ];

    /**
     * http://developers.facebook.com/docs/reference/api/user/
     *
     * @see FacebookOAuth2Service::fetchAttributes()
     */
    protected function fetchAttributes()
    {
        $this->attributes = $this->makeSignedRequest('me', [
            'query' => [
                'fields' => join(',', [
                    'id',
                    'name',
                    'link',
                    'email',
                    'verified',
                    'first_name',
                    'last_name',
                    'gender',
                    'birthday',
                    'hometown',
                    'location',
                    'locale',
                    'timezone',
                    'updated_time',
                ])
            ]
        ]);

        return true;
    }
}