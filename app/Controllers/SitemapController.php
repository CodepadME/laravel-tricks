<?php

namespace Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;
use Tricks\Repositories\TagRepositoryInterface;
use Tricks\Repositories\TrickRepositoryInterface;
use Tricks\Repositories\CategoryRepositoryInterface;

class SitemapController extends BaseController
{
    /**
     * Trick repository.
     *
     * @var \Tricks\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Tag repository.
     *
     * @var \Tricks\Repositories\TagRepositoryInterface
     */
    protected $tags;

    /**
     * Category repository.
     *
     * @var \Tricks\Repositories\CategoryRepositoryInterface
     */
    protected $categories;

    /**
     * Sitemap.
     *
     * @var \Tricks\Repositories\TrickRepositoryInterface
     */
    protected $sitemap;

    /**
     * Create a new SitemapController instance.
     *
     * @param  \Tricks\Repositories\TrickRepositoryInterface  $tricks
     * @return void
     */
    public function __construct(
        TrickRepositoryInterface $tricks,
        CategoryRepositoryInterface $categories,
        TagRepositoryInterface $tags
    ) {
        parent::__construct();

        $this->tricks       = $tricks;
        $this->tags         = $tags;
        $this->categories   = $categories;

        $this->sitemap = App::make("sitemap");
    }

    /**
     * Add URLs to static pages.
     *
     * @return void
     */
    public function addStaticRoutes()
    {
        $this->sitemap->add(URL::to('/'), '2013-11-16T12:30:00+02:00', '1.0', 'daily');
        $this->sitemap->add(URL::to('about'), '2013-11-16T12:30:00+02:00', '0.7', 'monthly');
        $this->sitemap->add(URL::to('categories'), '2013-11-16T12:30:00+02:00', '0.7', 'monthly');
        $this->sitemap->add(URL::to('tags'), '2013-11-16T12:30:00+02:00', '0.7', 'monthly');
        $this->sitemap->add(URL::to('login'), '2013-11-16T12:30:00+02:00', '0.8', 'weekly');
        $this->sitemap->add(URL::to('register'), '2013-11-16T12:30:00+02:00', '0.8', 'weekly');

        return $this->sitemap;
    }

    /**
     * Add URLs to dynamic pages of the site.
     *
     * @return void
     */
    public function addDynamicRoutes()
    {
        $tricks = $this->tricks->findAllForSitemap();
        foreach($tricks as $trick) $this->sitemap->add(URL::to("tricks/{$trick->slug}"), $trick->created_at, '0.9', 'weekly');

        $categories = $this->categories->findAll();
        foreach($categories as $category) $this->sitemap->add(URL::to("categories/{$category->slug}"), $category->created_at, '0.9', 'daily');

        $tags = $this->tags->findAll();
        foreach($tags as $tag) $this->sitemap->add(URL::to("tags/{$tag->slug}"), $tag->created_at, '0.9', 'daily');

        return $this->sitemap;
    }

    /**
     * Show the sitemap.
     *
     * @return void
     */
    public function getIndex()
    {
        $sitemap = $this->addStaticRoutes();
        $sitemap = $this->addDynamicRoutes();

        return $sitemap->render('xml');
    }
}
