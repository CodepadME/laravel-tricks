<?php

namespace Controllers;

use Github;
use GithubProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Tricks\Repositories\UserRepositoryInterface;

class AuthController extends BaseController
{
    /**
     * User Repository.
     *
     * @var \Tricks\Repositories\UserRepositoryInterface
     */
    protected $users;

    /**
     * Create a new AuthController instance.
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
     * Show login form.
     *
     * @return \Response
     */
    public function getLogin()
    {
        $this->view('home.login');
    }

    /**
     * Post login form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin()
    {
        $credentials = Input::only([ 'username', 'password' ]);
        $remember    = Input::get('remember', false);

        if (str_contains($credentials['username'], '@')) {
            $credentials['email'] = $credentials['username'];
            unset($credentials['username']);
        }

        if (Auth::attempt($credentials, $remember)) {
            return $this->redirectIntended(route('user.index'));
        }

        return $this->redirectBack([ 'login_errors' => true ]);
    }

    /**
     * Show registration form.
     *
     * @return \Response
     */
    public function getRegister()
    {
        $this->view('home.register');
    }

    /**
     * Post registration form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister()
    {
        $form = $this->users->getRegistrationForm();

        if (! $form->isValid()) {
            return $this->redirectBack([ 'errors' => $form->getErrors() ]);
        }

        if ($user = $this->users->create($form->getInputData())) {
            Auth::login($user);

            return $this->redirectRoute('user.index', [], [ 'first_use' => true ]);
        }

        return $this->redirectRoute('home');
    }

    /**
     * Handle Github login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLoginWithGithub()
    {
        if (! Input::has('code')) {
            Session::keep([ 'url' ]);
            GithubProvider::authorize();
        } else {
            try {
                $user = Github::register(Input::get('code'));
                Auth::login($user);

                if (Session::get('password_required')) {
                    return $this->redirectRoute('user.settings', [], [
                        'update_password' => true
                    ]);
                }

                return $this->redirectIntended(route('user.index'));
            } catch (GithubEmailNotVerifiedException $e) {
                return $this->redirectRoute('auth.register', [
                    'github_email_not_verified' => true
                ]);
            }
        }
    }

    /**
     * Logout the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        Auth::logout();

        return $this->redirectRoute('auth.login', [], [ 'logout_message' => true ]);
    }
}
