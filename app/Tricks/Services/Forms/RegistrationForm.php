<?php

namespace Tricks\Services\Forms;

use Illuminate\Config\Repository;

class RegistrationForm extends AbstractForm
{
    /**
     * Config repository instance.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * The validation rules to validate the input data against.
     *
     * @var array
     */
    protected $rules = [
        'username'  => 'required|min:4|alpha_num|unique:users,username',
        'email'     => 'required|email|min:5|unique:users',
        'password'  => 'required|min:6|confirmed'
    ];

    /**
     * Array of custom validation messages.
     *
     * @var array
     */
    protected $messages = [
        'not_in' => 'The selected username is reserved, please try a different username.'
    ];

    /**
     * Create a new RegistrationForm instance.
     *
     * @param  \Illuminate\Config\Repository  $config
     * @return void
     */
    public function __construct(Repository $config)
    {
        parent::__construct();

        $this->config = $config;
    }

    /**
     * Get the prepared validation rules.
     *
     * @return array
     */
    protected function getPreparedRules()
    {
        $forbidden = $this->config->get('config.forbidden_usernames');
        $forbidden = implode(',', $forbidden);

        $this->rules['username'] .= '|not_in:' . $forbidden;

        return $this->rules;
    }
}
