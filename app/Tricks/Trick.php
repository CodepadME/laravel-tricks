<?php

namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class Trick extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tricks';

	/**
	 * The class used to present the model.
	 *
	 * @var string
	 */
	public $presenter = 'Tricks\Presenters\TrickPresenter';

	/**
	 * The relations to eager load on every query.
	 *
	 * @var array
	 */
	protected $with = [ 'tags', 'categories', 'user' ];

	/**
	 * Query the tricks' votes.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function votes()
	{
		return $this->belongsToMany('Tricks\User', 'votes');
	}

	/**
	 * Query the user that posted the trick.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
    {
        return $this->belongsTo('Tricks\User');
    }

    /**
     * Query the tags under which the trick was posted.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
	public function tags()
	{
		return $this->belongsToMany('Tricks\Tag');
	}

	/**
	 * Query the categories under which the trick was posted.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function categories()
	{
		return $this->belongsToMany('Tricks\Category');
	}
}
