<?php

namespace App\Traits;

use App\Reply;

trait Replyable
{
    public function replies()
    {
        return $this->morphMany(Reply::class, 'replyable');
    }

    /**
     * Add a reply to the model.
     *
     * @param $attributes
     *
     * @return Model
     */
    public function reply($attributes)
    {
        return $this->replies()->create($attributes);
    }

}