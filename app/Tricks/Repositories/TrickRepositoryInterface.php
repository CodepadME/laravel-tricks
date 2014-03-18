<?php

namespace Tricks\Repositories;

use Tricks\User;
use Tricks\Trick;

interface TrickRepositoryInterface
{
    /**
     * Find all the tricks for the given user paginated.
     *
     * @param  \User $user
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function findAllForUser(User $user, $perPage = 9);

    /**
     * Find all tricks that are favorited by the given user paginated.
     *
     * @param  \User $user
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function findAllFavorites(User $user, $perPage = 9);

    /**
     * Find a trick by the given slug.
     *
     * @param  string $slug
     * @return \Tricks\Trick
     */
    public function findBySlug($slug);

    /**
     * Find all the tricks paginated.
     *
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function findAllPaginated($perPage = 9);

    /**
     * Find all tricks order by the creation date paginated.
     *
     * @param  integer $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function findMostRecent($per_page = 9);

    /**
     * Find the tricks ordered by the number of comments paginated.
     *
     * @param  integer $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function findMostCommented($per_page = 9);

    /**
     * Find the tricks ordered by popularity (most liked / viewed) paginated.
     *
     * @param  integer $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function findMostPopular($per_page = 9);

    /**
     * Find the last 15 tricks that were added.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Trick[]
     */
    public function findForFeed();

    /**
     * Find all tricks for sitemap.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Trick[]
     */
    public function findAllForSitemap();

    /**
     * Find all tricks that match the given search term.
     *
     * @param  string $term
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function searchByTermPaginated($term, $perPage);

    /**
     * Find all tricks for the category that matches the given slug.
     *
     * @param  string $slug
     * @param  integer $perPage
     * @return array
     */
    public function findByCategory($slug, $perPage = 9);

    /**
     * Get a list of tag ids that are associated with the given trick.
     *
     * @param  \Tricks\Trick $trick
     * @return array
     */
    public function listTagsIdsForTrick(Trick $trick);

    /**
     * Get a list of category ids that are associated with the given trick.
     *
     * @param  \Tricks\Trick $trick
     * @return array
     */
    public function listCategoriesIdsForTrick(Trick $trick);

    /**
     * Create a new trick in the database.
     *
     * @param  array $data
     * @return \Tricks\Trick
     */
    public function create(array $data);

    /**
     * Update the trick in the database.
     *
     * @param  \Tricks\Trick $trick
     * @param  array $data
     * @return \Tricks\Trick
     */
    public function edit(Trick $trick, array $data);

    /**
     * Increment the view count on the given trick.
     *
     * @param  \Tricks\Trick  $trick
     * @return \Tricks\Trick
     */
    public function incrementViews(Trick $trick);

    /**
     * Find all tricks for the tag that matches the given slug.
     *
     * @param  string $slug
     * @param  integer $perPage
     * @return array
     */
    public function findByTag($slug, $perPage = 9);

    /**
     * Find the next trick that was added after the given trick.
     *
     * @param  \Tricks\Trick  $trick
     * @return \Tricks\Trick|null
     */
    public function findNextTrick(Trick $trick);

    /**
     * Find the previous trick added before the given trick.
     *
     * @param  \Tricks\Trick  $trick
     * @return \Tricks\Trick|null
     */
    public function findPreviousTrick(Trick $trick);

    /**
     * Check if the user owns the trick corresponding to the given slug.
     *
     * @param  string  $slug
     * @param  mixed   $userId
     * @return bool
     */
    public function isTrickOwnedByUser($slug, $userId);
}
