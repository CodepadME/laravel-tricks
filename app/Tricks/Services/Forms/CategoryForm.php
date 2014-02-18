<?php

namespace Tricks\Services\Forms;

class CategoryForm extends AbstractForm
{
    /**
     * The validation rules to validate the input data against.
     *
     * @var array
     */
    protected $rules = [
        'name'        => 'required',
        'description' => 'required|min:4'
    ];
}
