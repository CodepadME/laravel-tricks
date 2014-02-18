<?php

namespace Controllers;

use Tricks\Repositories\TrickRepositoryInterface;

class HomeController extends BaseController
{
    /**
     * Trick repository.
     *
     * @var \Tricks\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Create a new HomeController instance.
     *
     * @param  \Tricks\Repositories\TrickRepositoryInterface  $tricks
     * @return void
     */
    public function __construct(TrickRepositoryInterface $tricks)
    {
        parent::__construct();

        $this->tricks = $tricks;
    }

    /**
     * Show the homepage.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $tricks = $this->tricks->findAllPaginated();

        $this->view('home.index', compact('tricks'));
    }

    /**
     * Show the about page.
     *
     * @return \Response
     */
    public function getAbout()
    {
        $this->view('home.about');
    }
}
