<?php

namespace App\Events\PostEvents;

use App\Models\Post;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class AbstractPostEvent
{
    use Dispatchable, SerializesModels;

    /** @var string event с типом создания статьи */
    const POST_EVENT_TYPE_CREATE = 'create';

    /** @var string event с типом обновления статьи */
    const POST_EVENT_TYPE_UPDATE = 'update';

    /** @var string event с типом удаления статьи */
    const POST_EVENT_TYPE_DELETE = 'delete';

    /**
     * Объект статьи
     * @var Post $post
     */
    public $post;

    /**
     * ТИп события
     * @var string
     */
    public $eventType;

    /**
     * Create a new event instance.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
