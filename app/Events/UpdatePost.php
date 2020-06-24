<?php

namespace App\Events;

use App\Models\Post;
use Arr;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdatePost implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Пост, который был обновлен
     *
     * @var Post
     */
    public $post;

    /**
     * Сообщение для отображения
     *
     * @var string
     */
    public $message;

    /**
     * Ссылка на измененную статью
     *
     * @var string
     */
    public $linkToPost;

    /**
     * Create a new event instance.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->message = $this->createMessage($post);
        $this->linkToPost = $this->createLink($post);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('admin');
    }

    /**
     * Ссылка на измененную статью
     *
     * @param Post $post
     * @return string
     */
    private function createLink(Post $post)
    {
        return route('posts.show', $post->slug);
    }

    private function createMessage(Post $post)
    {
        $afterEdit = $post->getDirty();
        unset($afterEdit['publish']);
        $beforeEdit = Arr::only($post->fresh()->toArray(), array_keys($afterEdit));
        $message = '';
        $message .= 'Что изменилось: ' . json_encode($beforeEdit) . '. ';
        $message .= 'На что изменилось: ' . json_encode($afterEdit);
        return $message;
    }
}
