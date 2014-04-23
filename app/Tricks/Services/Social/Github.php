<?php

namespace Tricks\Services\Social;

use Illuminate\Config\Repository;
use Tricks\Repositories\UserRepositoryInterface;
use Tricks\Repositories\ProfileRepositoryInterface;
use Tricks\Exceptions\GithubEmailNotVerifiedException;
use League\OAuth2\Client\Provider\Github as GithubProvider;

class Github
{
    /**
     * Provider for Github interactions.
     *
     * @var \League\OAuth2\Client\Provider\Github
     */
    protected $provider;

    /**
     * Profile repository.
     *
     * @var \Tricks\Repositories\ProfileRepositoryInterface
     */
    protected $profiles;

    /**
     * User repository.
     *
     * @var \Tricks\Repositories\UserRepositoryInterface
     */
    protected $users;

    /**
     * Config repository.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Create a new Github registration instance.
     *
     * @param  \League\OAuth2\Client\Provider\Github  $provider
     * @param  \Tricks\Repositories\UserRepositoryInterface  $users
     * @param  \Tricks\Repositories\ProfileRepositoryInterface  $profiles
     * @return void
     */
    public function __construct(
        GithubProvider $provider,
        Repository $config,
        UserRepositoryInterface $users,
        ProfileRepositoryInterface $profiles
    ) {
        $this->provider = $provider;
        $this->config   = $config;
        $this->users    = $users;
        $this->profiles = $profiles;
    }

    /**
     * Get a config item.
     *
     * @param  mixed $key
     * @return mixed
     */
    protected function getConfig($key = null)
    {
        $key = is_null($key) ? '' : '.' . $key;

        return $this->config->get('social.github' . $key);
    }

    /**
     * Register a new user using their Github account.
     *
     * @param  string $code
     * @return \Tricks\User
     */
    public function register($code)
    {
        $token = $this->provider->getAccessToken('authorization_code', [ 'code' => $code ]);

        $userDetails    = $this->provider->getUserDetails($token);
        $verifiedEmails = $this->getVerifiedEmails($token->accessToken);

        $userDetails->email = $this->getPrimaryEmail($verifiedEmails);

        $profile = $this->profiles->findByUid($userDetails->uid);

        if (is_null($profile)) {
            $user = $this->users->findByEmail($userDetails->email);

            if (is_null($user)) {
                $user = $this->users->createFromGithubData($userDetails);
            }

            $profile = $this->profiles->createFromGithubData($userDetails, $user, $token->accessToken);
        } else {
            $profile = $this->profiles->updateToken($profile, $token->accessToken);
            $user    = $profile->user;
        }

        return $user;
    }

    /**
     * Get the primary, verified email address from the Github data.
     *
     * @param  mixed $emails
     * @return mixed
     */
    protected function getPrimaryEmail($emails)
    {
        foreach ($emails as $email) {
            if (! $email->primary) {
                continue;
            }

            if ($email->verified) {
                return $email->email;
            }

            throw new GithubEmailNotVerifiedException;
        }

        return null;
    }

    /**
     * Get all the users email addresses
     *
     * @param  string $token
     * @return mixed
     */
    protected function getVerifiedEmails($token)
    {
        $ch = curl_init('https://api.github.com/user/emails?access_token='.$token);
        $userAgent  = $this->getConfig('user_agent');

        $options = [
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_HTTPHEADER      => [
                'Content-type: application/json',
                'Accept: application/vnd.github.v3',
                'User-Agent: '.$userAgent
            ]
        ];

        curl_setopt_array($ch, $options);

        $result = curl_exec($ch);
        if ($result === false) {
            $error = curl_error($ch);
            throw new GithubEmailAccessException($error);
        }
        
        return json_decode($result);
    }
}
