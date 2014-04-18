<?php

namespace Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;

class RemindersController extends BaseController
{
    /**
     * Display the password reminder view.
     *
     * @return \Response
     */
    public function getRemind()
    {
        $this->view('password.remind');
    }

    /**
     * Handle a POST request to remind a user of their password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRemind()
    {
        $result = Password::remind(Input::only('email'), function ($message, $user) {
            $message->subject(\Lang::get('reminders.your_password_reminder'));
        });

        switch ($result) {
            case Password::INVALID_USER:
                return Redirect::back()->with('success', true);

            case Password::REMINDER_SENT:
                return Redirect::back()->with('success', true);
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return \Response
     */
    public function getReset($token = null)
    {
        if (is_null($token)) {
            App::abort(404);
        }

        $this->view('password.reset', [ 'token' => $token ]);
    }

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postReset()
    {
        $credentials = Input::only([
            'email',
            'password',
            'password_confirmation',
            'token'
        ]);

        $response = Password::reset($credentials, function ($user, $password) {
            $user->password = Hash::make($password);

            $user->save();
        });

        switch ($response) {
            case Password::INVALID_PASSWORD:
            case Password::INVALID_TOKEN:
            case Password::INVALID_USER:
                return Redirect::back()->with('error', Lang::get($response));

            case Password::PASSWORD_RESET:
                return Redirect::to('login')->with('password_reset', true);
        }
    }
}
