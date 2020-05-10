<?php

namespace App\Mail\Posts;

use App\Events\PostEvents\AbstractPostEvent;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangePostStateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Событие
     * @var AbstractPostEvent $event
     */
    public $event;

    /**
     * Объект статьи
     * @var $post Post
     */
    public $post;

    /**
     * Тип event'a  вызвавшего слушателя
     * @var string $postEventType
     */
    public $postEventType;

    /**
     * Информация о статусе статьи по которой пришел event
     * @var string
     */
    public $postStatusType;

    /**
     * Create a new message instance.
     *
     * @param AbstractPostEvent $event
     */
    public function __construct(AbstractPostEvent $event)
    {
        $this->post = $event->post;
        $this->postEventType = $event->eventType;
        $this->postStatusType = $this->getPostStatusType($event->eventType);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.post.changeState');
    }

    /**
     * Возвращает информацию о том что произошло со статьей по которой пришел event
     * @param string $eventType
     * @return string
     */
    public function getPostStatusType(string $eventType)
    {
        $postType = null;
        switch ($eventType){
            case 'create':
                $postType = 'создана';
                break;
            case 'update':
                $postType = 'обновлена';
                break;
            case 'delete':
                $postType = 'удалена';
                break;
            default:
                $postType = 'undefined';
        }
        return $postType;
    }
}
