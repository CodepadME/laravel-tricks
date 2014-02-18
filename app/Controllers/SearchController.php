<?php

namespace Controllers;

use Illuminate\Support\Facades\Input;
use Tricks\Repositories\TrickRepositoryInterface;

class SearchController extends BaseController
{
    /**
     * Trick repository.
     *
     * @var \Tricks\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Create a new SearchController instance.
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
     * Show the search results page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $term   = e(Input::get('q'));
        $tricks = null;

        if (! empty($term)) {
            $tricks = $this->tricks->searchByTermPaginated($term, 12);
        }

        $this->view('search.result', compact('tricks', 'term'));
    }
}
