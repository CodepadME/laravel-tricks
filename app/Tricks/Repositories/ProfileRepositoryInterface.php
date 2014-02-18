<?php

namespace Tricks\Repositories;

use Tricks\User;
use Tricks\Profile;
use League\OAuth2\Client\Provider\User as OAuthUser;

interface ProfileRepositoryInterface
{
    /**
     * Find a profile by it's UID.
     *
     * @param  string $uid
     * @return \Tricks\Profile
     */
    public function findByUid($uid);

    /**
     * Create a new profile from Github data.
     *
     * @param  \League\OAuth2\Client\Provider\User $userDetails
     * @param  \Tricks\User  $user
     * @param  string  $token
     * @return \Tricks\Profile
     */
    public function createFromGithubData(OAuthUser $details, User $user, $token);

    /**
     * Update the access token on the profile.
     *
     * @param  \Tricks\Profile $profile
     * @param  string  $token
     * @return \Tricks\Profile
     */
    public function updateToken(Profile $profile, $token);
}
