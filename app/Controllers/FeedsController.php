<?php

namespace Controllers;

use Tricks\Services\Feeds\Builder;

class FeedsController extends BaseController
{
    /**
     * Feed builder instance.
     *
     * @var \Tricks\Services\Feeds\Builder
     */
    protected $builder;

    /**
     * Create a new FeedsController instance.
     *
     * @param  \Tricks\Services\Feeds\Builder  $builder
     * @return void
     */
    public function __construct(Builder $builder)
    {
        parent::__construct();

        $this->builder = $builder;
    }

    /**
     * Show the ATOM feed.
     *
     * @return \Response
     */
    public function getAtom()
    {
        $this->builder->setType('atom');

        return $this->builder->render();
    }

    /**
     * Show the RSS feed.
     *
     * @return \Response
     */
    public function getRss()
    {
        $this->builder->setType('rss');

        return $this->builder->render();
    }
}
