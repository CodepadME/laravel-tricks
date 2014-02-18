<?php

namespace Tricks\Repositories;

interface CategoryRepositoryInterface
{
    /**
     * Get an array of key-value (id => name) pairs of all categories.
     *
     * @return array
     */
    public function listAll();

    /**
     * Find all categories.
     *
     * @param  string $orderColumn
     * @param  string $orderDir
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Category[]
     */
    public function findAll($orderColumn = 'created_at', $orderDir = 'desc');

    /**
     * Find all categories with the associated number of tricks.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Category[]
     */
    public function findAllWithTrickCount();

    /**
     * Find a category by id.
     *
     * @param  mixed $id
     * @return \Tricks\Category
     */
    public function findById($id);

    /**
     * Create a new category in the database.
     *
     * @param  array $data
     * @return \Tricks\Category
     */
    public function create(array $data);

    /**
     * Update the specified category in the database.
     *
     * @param  mixed $id
     * @param  array $data
     * @return \Tricks\Category
     */
    public function update($id, array $data);

    /**
     * The the highest order number from the database.
     *
     * @return int
     */
    public function getMaxOrder();

    /**
     * Delete the specified category from the database.
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id);

    /**
     * Re-arrange the categories in the database.
     *
     * @param  array $data
     * @return void
     */
    public function arrange(array $data);
}
