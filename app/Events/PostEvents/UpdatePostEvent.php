<?php

namespace App\Events\PostEvents;

use App\Models\Post;

class UpdatePostEvent extends AbstractPostEvent
{
    /**
     * CreatePostEvent constructor.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        parent::__construct($post);
        $this->eventType = static::POST_EVENT_TYPE_UPDATE;
    }
}
