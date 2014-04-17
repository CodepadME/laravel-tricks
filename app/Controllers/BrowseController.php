<?php

namespace Controllers;

use Tricks\Repositories\TagRepositoryInterface;
use Tricks\Repositories\TrickRepositoryInterface;
use Tricks\Repositories\CategoryRepositoryInterface;

class BrowseController extends BaseController
{
    /**
     * Category repository.
     *
     * @var \Tricks\Repositories\CategoryRepositoryInterface
     */
    protected $categories;

    /**
     * Tags repository.
     *
     * @var \Tricks\Repositories\TagRepositoryInterface
     */
    protected $tags;

    /**
     * Trick repository.
     *
     * @var \Tricks\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Create a new BrowseController instance.
     *
     * @param  \Tricks\Repositories\CategoryRepositoryInterface  $categories
     * @param  \Tricks\Repositories\TagRepositoryInterface  $tags
     * @param  \Tricks\Repositories\TrickRepositoryInterface  $tricks
     * @return void
     */
    public function __construct(
        CategoryRepositoryInterface $categories,
        TagRepositoryInterface $tags,
        TrickRepositoryInterface $tricks
    ) {
        parent::__construct();

        $this->categories = $categories;
        $this->tags       = $tags;
        $this->tricks     = $tricks;
    }

    /**
     * Show the categories index.
     *
     * @return \Response
     */
    public function getCategoryIndex()
    {
        $categories = $this->categories->findAllWithTrickCount();

        $this->view('browse.categories', compact('categories'));
    }

    /**
     * Show the browse by category page.
     *
     * @param  string  $category
     * @return \Response
     */
    public function getBrowseCategory($category)
    {
        list($category, $tricks) = $this->tricks->findByCategory($category);

        $type      = \Lang::get('browse.category', array('category' => $category->name));
        $pageTitle = \Lang::get('browse.browsing_category', array('category' => $category->name));

        $this->view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }

    /**
     * Show the tags index.
     *
     * @return \Response
     */
    public function getTagIndex()
    {
        $tags = $this->tags->findAllWithTrickCount();

        $this->view('browse.tags', compact('tags'));
    }

    /**
     * Show the browse by tag page.
     *
     * @param  string  $tag
     * @return \Response
     */
    public function getBrowseTag($tag)
    {
        list($tag, $tricks) = $this->tricks->findByTag($tag);

        $type      = \Lang::get('browse.tag', array('tag' => $tag->name));
        $pageTitle = \Lang::get('browse.browsing_tag', array('tag' => $tag->name));

        $this->view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }

    /**
     * Show the browse recent tricks page.
     *
     * @return \Response
     */
    public function getBrowseRecent()
    {
        $tricks = $this->tricks->findMostRecent();

        $type      = \Lang::get('browse.recent');
        $pageTitle = \Lang::get('browse.browsing_most_recent_tricks');

        $this->view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }

    /**
     * Show the browse popular tricks page.
     *
     * @return \Response
     */
    public function getBrowsePopular()
    {
        $tricks = $this->tricks->findMostPopular();

        $type      = \Lang::get('browse.popular');
        $pageTitle = \Lang::get('browse.browsing_most_popular_tricks');

        $this->view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }

    /**
     * Show the browse most commented tricks page.
     *
     * @return \Response
     */
    public function getBrowseComments()
    {
        $tricks = $this->tricks->findMostCommented();

        $type      = \Lang::get('browse.most_commented');
        $pageTitle = \Lang::get('browse.browsing_most_commented_tricks');

        $this->view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }
}
