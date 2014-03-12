<?php

namespace Controllers\Admin;

use Controllers\BaseController;
use Illuminate\Support\Facades\Input;
use Tricks\Repositories\CategoryRepositoryInterface;

class CategoriesController extends BaseController
{
    /**
     * Category repository.
     *
     * @var \Tricks\Repositories\CategoryRepositoryInterface
     */
    protected $categories;

    /**
     * Create a new CategoriesController instance.
     *
     * @param  \Tricks\Repositories\CategoryRepositoryInterface  $categories
     * @return void
     */
    public function __construct(CategoryRepositoryInterface $categories)
    {
        parent::__construct();

        $this->categories = $categories;
    }

    /**
     * Show the admin categories index page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $categories = $this->categories->findAll('order', 'asc');

        $this->view('admin.categories.list', compact('categories'));
    }

    /**
     * Handle the creation of a category.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postIndex()
    {
        $form = $this->categories->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.categories.index')
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $category = $this->categories->create($form->getInputData());

        return $this->redirectRoute('admin.categories.index');
    }

    /**
     * Update the order of the categories.
     *
     * @return \Response
     */
    public function postArrange()
    {
        $decoded = Input::get('data');

        if ($decoded) {
            $this->categories->arrange($decoded);
        }

        return 'ok';
    }

    /**
     * Show the category edit form.
     *
     * @param  mixed $id
     * @return \Response
     */
    public function getView($id)
    {
        $category = $this->categories->findById($id);

        $this->view('admin.categories.edit', compact('category'));
    }

    /**
     * Handle the editing of a category.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postView($id)
    {
        $form = $this->categories->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.categories.view', $id)
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $category = $this->categories->update($id, $form->getInputData());

        return $this->redirectRoute('admin.categories.view', $id);
    }

    /**
     * Delete a category from the database.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $this->categories->delete($id);

        return $this->redirectRoute('admin.categories.index');
    }
}
