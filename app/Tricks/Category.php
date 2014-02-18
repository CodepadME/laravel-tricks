<?php

namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Query the tricks that belong to the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
	public function tricks()
	{
		return $this->belongsToMany('Tricks\Trick');
	}
}
