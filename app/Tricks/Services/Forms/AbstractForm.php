<?php

namespace Tricks\Services\Forms;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

abstract class AbstractForm
{
    /**
     * The input data of the current request.
     *
     * @var array
     */
    protected $inputData;

    /**
     * The validation rules to validate the input data against.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * The validator instance.
     *
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * Array of custom validation messages.
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Create a new Form instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->inputData = App::make('request')->all();
    }

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return $this->inputData;
    }

    /**
     * Returns whether the input data is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        $this->validator = Validator::make(
            $this->getInputData(),
            $this->getPreparedRules(),
            $this->getMessages()
        );

        return $this->validator->passes();
    }

    /**
     * Get the validation errors off of the Validator instance.
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors()
    {
        return $this->validator->errors();
    }

    /**
     * Get the prepared validation rules.
     *
     * @return array
     */
    protected function getPreparedRules()
    {
        return $this->rules;
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    protected function getMessages()
    {
        return $this->messages;
    }
}
