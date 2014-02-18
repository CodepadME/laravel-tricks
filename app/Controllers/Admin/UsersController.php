<?php

namespace Controllers\Admin;

use Controllers\BaseController;
use Tricks\Repositories\UserRepositoryInterface;

class UsersController extends BaseController
{
    /**
     * User repository.
     *
     * @var \Tricks\Repositories\UserRepositoryInterface
     */
    protected $users;

    /**
     * Create a new UsersController instance.
     *
     * @param  \Tricks\Repositories\UserRepositoryInterface $users
     * @return void
     */
    public function __construct(UserRepositoryInterface $users)
    {
        parent::__construct();

        $this->users = $users;
    }

    /**
     * Show the users index page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $users = $this->users->findAllPaginated();

        $this->view('admin.users.list', compact('users'));
    }
}
