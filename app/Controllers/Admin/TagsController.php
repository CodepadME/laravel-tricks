<?php

namespace Controllers\Admin;

use Controllers\BaseController;
use Tricks\Repositories\TagRepositoryInterface;

class TagsController extends BaseController
{
    /**
     * Tag repository.
     *
     * @var \Tricks\Repositories\TagRepositoryInterface
     */
    protected $tags;

    /**
     * Create a new TagsController instance.
     *
     * @param  \Tricks\Repositories\TagRepositoryInterface  $tags
     * @return void
     */
    public function __construct(TagRepositoryInterface $tags)
    {
        parent::__construct();

        $this->tags = $tags;
    }

    /**
     * Show the tags index page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $tags = $this->tags->findAll();

        $this->view('admin.tags.list', compact('tags'));
    }

    /**
     * Delete a tag from the database.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $this->tags->delete($id);

        return $this->redirectRoute('admin.tags.index');
    }

    /**
     * Show the tag edit form.
     *
     * @param  mixed $id
     * @return \Response
     */
    public function getView($id)
    {
        $tag = $this->tags->findById($id);

        $this->view('admin.tags.edit', compact('tag'));
    }

    /**
     * Handle the creation of a tag.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postIndex()
    {
        $form = $this->tags->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.tags.index')
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $tag = $this->tags->create($form->getInputData());

        return $this->redirectRoute('admin.tags.index');
    }

    /**
     * Handle the editing of a tag.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postView($id)
    {
        $form = $this->tags->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.tags.view', $id)
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $tag = $this->tags->update($id, $form->getInputData());

        return $this->redirectRoute('admin.tags.view', $id);
    }
}
