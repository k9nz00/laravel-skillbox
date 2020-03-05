<?php

namespace App\Notifications\PostNotafication;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChangePostStateNotification extends Notification
{
    use Queueable;

    const POST_TYPE_STATUS_CREATE = 'create';
    const POST_TYPE_STATUS_UPDATE = 'update';
    const POST_TYPE_STATUS_DELETE = 'delete';

    /**
     * Статья
     * @var Post $post
     */
    public $post;

    /**
     * Тема сообщения
     * @var string $subjectMessage
     */
    public $subjectMessage;

    /**
     * Статус статьи
     * @var string $postTypeStatus
     */
    public $postTypeStatus;

    /**
     * ChangePostStateNotification constructor.
     * @param Post $post
     * @param string $subjectMessage
     * @param string $postTypeStatus
     */
    public function __construct(Post $post, string $subjectMessage, string $postTypeStatus)
    {
        $this->post = $post;
        $this->subjectMessage = $subjectMessage;
        $this->postTypeStatus = $postTypeStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailMessage = new MailMessage;
        $mailMessage
            ->line('На сайте произошли изменения')
            ->line($this->subjectMessage);
        if ($this->postTypeStatus != self::POST_TYPE_STATUS_DELETE){
            $mailMessage->action('Посмотреть статью', url()->route('post.show', $this->post->slug));
        }

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase()
    {
        return [$this->post];
    }
}
