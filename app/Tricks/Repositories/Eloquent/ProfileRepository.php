<?php

namespace Tricks\Repositories\Eloquent;

use Tricks\User;
use Tricks\Profile;
use Tricks\Repositories\ProfileRepositoryInterface;
use League\OAuth2\Client\Provider\User as OAuthUser;

class ProfileRepository extends AbstractRepository implements ProfileRepositoryInterface
{
    /**
     * Create a new DbProfileRepository instance.
     *
     * @param  \Tricks\Profile $profile
     * @return void
     */
    public function __construct(Profile $profile)
    {
        $this->model = $profile;
    }

    /**
     * Find a profile by it's UID.
     *
     * @param  string  $uid
     * @return \Tricks\Profile
     */
    public function findByUid($uid)
    {
        return $this->model->whereUid($uid)->first();
    }

    /**
     * Create a new profile from Github data.
     *
     * @param  \League\OAuth2\Client\Provider\User  $userDetails
     * @param  \Tricks\User  $user
     * @param  string  $token
     * @return \Tricks\Profile
     */
    public function createFromGithubData(OAuthUser $details, User $user, $token)
    {
        $profile = $this->getNew();

        $profile->uid          = $details->uid;
        $profile->username     = $details->nickname;
        $profile->name         = $details->name;
        $profile->email        = $details->email;
        $profile->first_name   = $details->first_name;
        $profile->last_name    = $details->last_name;
        $profile->location     = $details->location;
        $profile->description  = $details->description;
        $profile->image_url    = $details->imageUrl;
        $profile->access_token = $token;
        $profile->user_id      = $user->id;

        $profile->save();

        return $profile;
    }

    /**
     * Update the access token on the profile.
     *
     * @param  \Tricks\Profile  $profile
     * @param  string  $token
     * @return \Tricks\Profile
     */
    public function updateToken(Profile $profile, $token)
    {
        $profile->access_token = $token;
        $profile->save();

        return $profile;
    }
}
