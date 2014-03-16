<?php

namespace Tricks\Presenters;

use Tricks\User;
use McCool\LaravelAutoPresenter\BasePresenter;

class UserPresenter extends BasePresenter
{
    /**
     * Create a new UserPresenter instance.
     *
     * @param  \Tricks\User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->resource = $user;
    }

    /**
     * Get the timestamp of the last posted trick of this user.
     *
     * @param  \Illuminate\Pagination\Paginator  $tricks
     * @return string
     */
    public function lastActivity($tricks)
    {
        if (count($tricks) == 0) {
            return 'No activity';
        }

        $collection = $tricks->getCollection();
        $sorted     = $collection->sortBy(function ($trick) {
            return $trick->created_at;
        })->reverse();

        $last = $sorted->first();

        return $last->created_at->diffForHumans();
    }

    /**
     * Get the full name of this user.
     *
     * @return string
     */
    public function fullName()
    {
        $profile = $this->resource->profile;

        if (! is_null($profile) && ! empty($profile->name)) {
            return $profile->name;
        }

        return $this->resource->username;
    }
}
