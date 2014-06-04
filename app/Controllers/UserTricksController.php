<?php

namespace Controllers;

use Illuminate\Support\Facades\Auth;
use Tricks\Repositories\TagRepositoryInterface;
use Tricks\Repositories\TrickRepositoryInterface;
use Tricks\Repositories\CategoryRepositoryInterface;

class UserTricksController extends BaseController
{
    /**
     * Trick repository.
     *
     * @var \Tricks\Repositories\TrickRepositoryInterface
     */
    protected $trick;

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
     * Create a new TrickController instance.
     *
     * @param  \Tricks\Repositories\TrickRepositoryInterface  $trick
     * @param  \Tricks\Repositories\TagRepositoryInterface  $tags
     * @param  \Tricks\Repositories\CategoryRepositoryInterface  $categories
     * @return void
     */
    public function __construct(
        TrickRepositoryInterface $trick,
        TagRepositoryInterface $tags,
        CategoryRepositoryInterface $categories
    ) {
        parent::__construct();

        $this->beforeFilter('auth');
        $this->beforeFilter('trick.owner', [
            'only' => [ 'getEdit', 'postEdit', 'getDelete' ]
        ]);

        $this->trick      = $trick;
        $this->tags       = $tags;
        $this->categories = $categories;
    }

    /**
     * Show the create new trick page.
     *
     * @return \Response
     */
    public function getNew()
    {
        $tagList      = $this->tags->listAll();
        $categoryList = $this->categories->listAll();

        $this->view('tricks.new', compact('tagList', 'categoryList'));
    }

    /**
     * Handle the creation of a new trick.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postNew()
    {
        $form = $this->trick->getCreationForm();

        if (! $form->isValid()) {
            return $this->redirectBack([ 'errors' => $form->getErrors() ]);
        }

        $data = $form->getInputData();
        $data['user_id'] = Auth::user()->id;

        $trick = $this->trick->create($data);

        return $this->redirectRoute('user.index');
    }

    /**
     * Show the edit trick page.
     *
     * @param  string $slug
     * @return \Response
     */
    public function getEdit($slug)
    {
        $trick        = $this->trick->findBySlug($slug);
        $tagList      = $this->tags->listAll();
        $categoryList = $this->categories->listAll();

        $selectedTags       = $this->trick->listTagsIdsForTrick($trick);
        $selectedCategories = $this->trick->listCategoriesIdsForTrick($trick);

        $this->view('tricks.edit', [
            'tagList'            => $tagList,
            'selectedTags'       => $selectedTags,
            'categoryList'       => $categoryList,
            'selectedCategories' => $selectedCategories,
            'trick'              => $trick
        ]);
    }

    /**
     * Handle the editing of a trick.
     *
     * @param  string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($slug)
    {
        $trick = $this->trick->findBySlug($slug);
        $form  = $this->trick->getEditForm($trick->id);

        if (! $form->isValid()) {
            return $this->redirectBack([ 'errors' => $form->getErrors() ]);
        }

        $data  = $form->getInputData();
        $trick = $this->trick->edit($trick, $data);

        return $this->redirectRoute('tricks.edit', [ $trick->slug ], [
            'success' => \Lang::get('user_tricks.trick_updated')
        ]);
    }

    /**
     * Delete a trick from the database.
     *
     * @param  string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($slug)
    {
        $trick = $this->trick->findBySlug($slug);

        $trick->tags()->detach();
        $trick->categories()->detach();
        $trick->delete();

        return $this->redirectRoute('user.index', null, [
            'success' => \Lang::get('user_tricks.trick_deleted')
        ]);
    }
}
