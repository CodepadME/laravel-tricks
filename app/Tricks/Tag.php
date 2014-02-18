<?php

namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * Query the tricks that belong to the tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
	public function tricks()
	{
		return $this->belongsToMany('Tricks\Trick');
	}
}
