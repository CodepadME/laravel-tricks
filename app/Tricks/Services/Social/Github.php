<?php

namespace Tricks\Services\Social;

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
     * Create a new Github registration instance.
     *
     * @param  \League\OAuth2\Client\Provider\Github  $provider
     * @param  \Tricks\Repositories\UserRepositoryInterface  $users
     * @param  \Tricks\Repositories\ProfileRepositoryInterface  $profiles
     * @return void
     */
    public function __construct(
        GithubProvider $provider,
        UserRepositoryInterface $users,
        ProfileRepositoryInterface $profiles
    ) {
        $this->provider = $provider;
        $this->users    = $users;
        $this->profiles = $profiles;
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

        $options = [
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_HTTPHEADER      => [
                'Content-type: application/json',
                'Accept: application/vnd.github.v3',
                'User-Agent: msurguy'
            ]
        ];

        curl_setopt_array($ch, $options);

        return json_decode(curl_exec($ch));
    }
}
