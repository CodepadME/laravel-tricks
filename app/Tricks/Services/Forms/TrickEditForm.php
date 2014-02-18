<?php

namespace Tricks\Services\Forms;

class TrickEditForm extends AbstractForm
{
    /**
     * The id of the trick.
     *
     * @var mixed
     */
    protected $id;

    /**
     * The validation rules to validate the input data against.
     *
     * @var array
     */
    protected $rules = [
        'title'         => 'required|min:4|unique:tricks,title',
        'description'   => 'required|min:10',
        'tags'          => 'required',
        'categories'    => 'required',
        'code'          => 'required'
    ];

    public function __construct($id)
    {
        parent::__construct();

        $this->id = $id;
    }

    /**
     * Get the prepared validation rules.
     *
     * @return array
     */
    protected function getPreparedRules()
    {
        $this->rules['title'] .= ',' . $this->id;

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
            'title', 'description', 'tags', 'categories', 'code'
        ]);
    }
}
