<?php

namespace Tricks\Repositories;

use League\OAuth2\Client\Provider\User as OAuthUser;
use Tricks\User;

interface UserRepositoryInterface
{
    /**
     * Find all users paginated.
     *
     * @param int $perPage
     *
     * @return \Illuminate\Pagination\Paginator|\User[]
     */
    public function findAllPaginated($perPage = 200);

    /**
     * Find a user by it's username.
     *
     * @param string $username
     *
     * @return \Tricks\User
     */
    public function findByUsername($username);

    /**
     * Find a user by it's email.
     *
     * @param string $email
     *
     * @return \Tricks\User
     */
    public function findByEmail($email);

    /**
     * Require a user by it's username.
     *
     * @param string $username
     *
     * @throws \Tricks\Exceptions\UserNotFoundException
     *
     * @return \Tricks\User
     */
    public function requireByUsername($username);

    /**
     * Create a new user in the database.
     *
     * @param array $data
     *
     * @return \Tricks\User
     */
    public function create(array $data);

    /**
     * Create a new user in the database using GitHub data.
     *
     * @param array $data
     *
     * @return \Tricks\User
     */
    public function createFromGithubData(OAuthUser $data);

    /**
     * Update the user's settings.
     *
     * @param array $data
     *
     * @return \Tricks\User
     */
    public function updateSettings(User $user, array $data);
}
