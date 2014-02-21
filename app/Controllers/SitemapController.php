<?php

namespace Controllers;

use Tricks\Services\Sitemap\Builder;

class SitemapController extends BaseController
{
    /**
     * Sitemap builder instance.
     *
     * @var \Tricks\Services\Sitemap\Builder
     */
    protected $builder;

    /**
     * Create a new SitemapController instance.
     *
     * @param  \Tricks\Services\Sitemap\Builder  $builder
     * @return void
     */
    public function __construct(Builder $builder)
    {
        parent::__construct();

        $this->builder = $builder;
    }

    /**
     * Show the sitemap.
     *
     * @return void
     */
    public function getIndex()
    {
        return $this->builder->render();
    }
}
