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
        return $this->builder->render('atom');
    }

    /**
     * Show the RSS feed.
     *
     * @return \Response
     */
    public function getRss()
    {
        return $this->builder->render('rss');
    }
}
