<?php

namespace Tricks\Services\Forms;

use Illuminate\Auth\AuthManager;
use Illuminate\Config\Repository;

class SettingsForm extends AbstractForm
{
    /**
     * Config repository instance.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Auth manager instance.
     *
     * @var \Illuminate\Auth\AuthManager
     */
    protected $auth;

    /**
     * The validation rules to validate the input data against.
     *
     * @var array
     */
    protected $rules = [
        'username' => 'required|min:4',
        'password' => 'confirmed|min:6'
    ];

    /**
     * Create a new SettingsForm instance.
     *
     * @param  \Illuminate\Config\Repository  $config
     * @param  \Illuminate\Auth\AuthManager   $auth
     * @return void
     */
    public function __construct(Repository $config, AuthManager $auth)
    {
        parent::__construct();

        $this->config = $config;
        $this->auth = $auth;
    }

    /**
     * Get the prepared validation rules.
     *
     * @return array
     */
    protected function getPreparedRules()
    {
        $forbidden = implode(',', $this->config->get('config.forbidden_usernames'));
        $userId    = $this->auth->user()->id;

        $this->rules['username'] .= '|not_in:' . $forbidden;
        $this->rules['username'] .= '|unique:users,username,' . $userId;

        return $this->rules;
    }

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'username', 'password', 'password_confirmation'
        ]);
    }
}
