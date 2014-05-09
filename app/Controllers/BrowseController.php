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

        $htmlTitle = \Lang::get('browse.html_title.category', array('category' => $category->name));
        $pageTitle = \Lang::get('browse.page_title.category', array('category' => $category->name));

        $this->view('browse.index', compact('tricks', 'htmlTitle', 'pageTitle'));
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

        $htmlTitle = \Lang::get('browse.html_title.tag', array('tag' => $tag->name));
        $pageTitle = \Lang::get('browse.page_title.tag', array('tag' => $tag->name));

        $this->view('browse.index', compact('tricks', 'htmlTitle', 'pageTitle'));
    }

    /**
     * Show the browse recent tricks page.
     *
     * @return \Response
     */
    public function getBrowseRecent()
    {
        $tricks = $this->tricks->findMostRecent();

        $htmlTitle = \Lang::get('browse.html_title.recent_tricks');
        $pageTitle = \Lang::get('browse.page_title.recent_tricks');

        $this->view('browse.index', compact('tricks', 'htmlTitle', 'pageTitle'));
    }

    /**
     * Show the browse popular tricks page.
     *
     * @return \Response
     */
    public function getBrowsePopular()
    {
        $tricks = $this->tricks->findMostPopular();

        $htmlTitle = \Lang::get('browse.html_title.popular_tricks');
        $pageTitle = \Lang::get('browse.page_title.popular_tricks');

        $this->view('browse.index', compact('tricks', 'htmlTitle', 'pageTitle'));
    }

    /**
     * Show the browse most commented tricks page.
     *
     * @return \Response
     */
    public function getBrowseComments()
    {
        $tricks = $this->tricks->findMostCommented();

        $htmlTitle = \Lang::get('browse.html_title.most_commented_tricks');
        $pageTitle = \Lang::get('browse.page_title.most_commented_tricks');

        $this->view('browse.index', compact('tricks', 'htmlTitle', 'pageTitle'));
    }
}
