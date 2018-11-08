<?php

namespace Audentio\OAuth2\Client\IMLeagues\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class IMLeaguesUser implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    protected $response;

    public function getId()
    {
        return $this->getValue('id');
    }

    public function getEmail()
    {
        return $this->getValue('email');
    }

    public function getDob()
    {
        return $this->getValue('dob');
    }

    public function getNetwork()
    {
        return $this->getValue('network');
    }

    public function getYearsInSchool()
    {
        return $this->getValue('years_in_school');
    }

    public function getGradYear()
    {
        return $this->getValue('grad_year');
    }

    public function getActive()
    {
        return $this->getValue('active', false);
    }

    public function getAnswers()
    {
        return $this->getValue('answers');
    }

    public function getFirstName()
    {
        return $this->getValue('first_name');
    }

    public function getLastName()
    {
        return $this->getValue('last_name');
    }

    public function getAvatarUrl()
    {
        return $this->getValue('avatar_url');
    }

    public function toArray()
    {
        return $this->response;
    }

    protected function getValue($key, $defaultVal = null)
    {
        if (!array_key_exists($key, $this->response)) {
            return $defaultVal;
        }

        return $this->response[$key];
    }


    public function __construct(array $response)
    {
        $this->response = $response;
    }
}
