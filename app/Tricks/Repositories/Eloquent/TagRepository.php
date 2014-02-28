<?php

namespace Tricks\Repositories\Eloquent;

use Tricks\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Tricks\Services\Forms\TagForm;
use Tricks\Exceptions\TagNotFoundException;
use Tricks\Repositories\TagRepositoryInterface;

class TagRepository extends AbstractRepository implements TagRepositoryInterface
{
    /**
     * Create a new DbTagRepository instance.
     *
     * @param  \Tricks\Tag $tags
     * @return void
     */
    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }

    /**
     * Get an array of key-value (id => name) pairs of all tags.
     *
     * @return array
     */
    public function listAll()
    {
        $tags = $this->model->lists('name', 'id');

        return $tags;
    }

    /**
     * Find all tags.
     *
     * @param  string  $orderColumn
     * @param  string  $orderDir
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Tag[]
     */
    public function findAll($orderColumn = 'created_at', $orderDir = 'desc')
    {
        $tags = $this->model
                     ->orderBy($orderColumn, $orderDir)
                     ->get();

        return $tags;
    }

    /**
     * Find a tag by id.
     *
     * @param  mixed  $id
     * @return \Tricks\Tag
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Find all tags with the associated number of tricks.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Tag[]
     */
    public function findAllWithTrickCount()
    {
        return $this->model
                    ->leftJoin('tag_trick', 'tags.id', '=', 'tag_trick.tag_id')
                    ->leftJoin('tricks', 'tricks.id', '=', 'tag_trick.trick_id')
                    ->groupBy('tags.slug')
                    ->orderBy('trick_count', 'desc')
                    ->get([
                        'tags.name',
                        'tags.slug',
                        DB::raw('COUNT(tricks.id) as trick_count')
                    ]);
    }

    /**
     * Create a new tag in the database.
     *
     * @param  array  $data
     * @return \Tricks\Tag
     */
    public function create(array $data)
    {
        $tag = $this->getNew();

        $tag->name = $data['name'];
        $tag->slug = Str::slug($tag->name, '-');

        $tag->save();

        return $tag;
    }

    /**
     * Update the specified tag in the database.
     *
     * @param  mixed  $id
     * @param  array  $data
     * @return \Tricks\Category
     */
    public function update($id, array $data)
    {
        $tag = $this->findById($id);

        $tag->name = $data['name'];
        $tag->slug = Str::slug($tag->name, '-');

        $tag->save();

        return $tag;
    }

    /**
     * Delete the specified tag from the database.
     *
     * @param  mixed  $id
     * @return void
     */
    public function delete($id)
    {
        $tag = $this->findById($id);

        $tag->tricks()->detach();

        $tag->delete();
    }

    /**
     * Get the tag create/update form service.
     *
     * @return \Tricks\Services\Forms\TagForm
     */
    public function getForm()
    {
        return new TagForm;
    }
}
