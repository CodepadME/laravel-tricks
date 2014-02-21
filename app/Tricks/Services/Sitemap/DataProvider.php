<?php

namespace Tricks\Services\Sitemap;

use Illuminate\Routing\UrlGenerator;
use Tricks\Repositories\TagRepositoryInterface;
use Tricks\Repositories\TrickRepositoryInterface;
use Tricks\Repositories\CategoryRepositoryInterface;

class DataProvider
{
    /**
     * The URL generator instance.
     *
     * @var \Illuminate\Routing\UrlGenerator
     */
    protected $url;

    /**
     * Tags repository instance.
     *
     * @var \Tricks\Repositories\TagRepositoryInterface
     */
    protected $tags;

    /**
     * Trick repository instance.
     *
     * @var \Tricks\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Category repository instance.
     *
     * @var \Tricks\Repositories\CategoryRepositoryInterface
     */
    protected $categories;

    /**
     * Create a new data provider instance.
     *
     * @param  \Illuminate\Routing\UrlGenerator                  $url
     * @param  \Tricks\Repositories\TagRepositoryInterface       $tags
     * @param  \Tricks\Repositories\TrickRepositoryInterface     $tricks
     * @param  \Tricks\Repositories\CategoryRepositoryInterface  $categories
     * @return void
     */
    public function __construct(
        UrlGenerator $url,
        TagRepositoryInterface $tags,
        TrickRepositoryInterface $tricks,
        CategoryRepositoryInterface $categories
    ) {
        $this->url = $url;
        $this->tags = $tags;
        $this->tricks = $tricks;
        $this->categories = $categories;
    }

    /**
     * Get all the tags to include in the sitemap.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Tag[]
     */
    public function getTags()
    {
        return $this->tags->findAll();
    }

    /**
     * Get the url for the given tag.
     *
     * @param  \Tricks\Tag  $tag
     * @return string
     */
    public function getTagUrl($tag)
    {
        return $this->url->route('tricks.browse.tag', $tag->slug);
    }

    /**
     * Get all the tricks to include in the sitemap.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Trick[]
     */
    public function getTricks()
    {
        return $this->tricks->findAllForSitemap();
    }

    /**
     * Get the url for the given trick.
     *
     * @param  \Tricks\Trick  $trick
     * @return string
     */
    public function getTrickUrl($trick)
    {
        return $this->url->route('tricks.show', $trick->slug);
    }

    /**
     * Get all the categories to include in the sitemap.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Category[]
     */
    public function getCategories()
    {
        return $this->categories->findAll();
    }

    /**
     * Get the url for the given category.
     *
     * @param  \Tricks\Category  $category
     * @return string
     */
    public function getCategoryUrl($category)
    {
        return $this->url->route('tricks.browse.category', $category->slug);
    }

    /**
     * Get all the static pages to include in the sitemap.
     *
     * @return array
     */
    public function getStaticPages()
    {
        $static = [];

        $static[] = $this->getPage('browse.recent', 'daily', '1.0');
        $static[] = $this->getPage('about', 'monthly', '0.7');
        $static[] = $this->getPage('browse.categories', 'monthly', '0.7');
        $static[] = $this->getPage('browse.tags', 'monthly', '0.7');
        $static[] = $this->getPage('auth.login', 'weekly', '0.8');
        $static[] = $this->getPage('auth.register', 'weekly', '0.8');

        return $static;
    }

    /**
     * Get the data for the given page.
     *
     * @param  string  $route
     * @param  string  $freq
     * @param  string  $priority
     * @return array
     */
    protected function getPage($route, $freq, $priority)
    {
        $url = $this->url->route($route);

        return compact('url', 'freq', 'priority');
    }
}
