<?php

namespace App\Notifications;

use App\Helpers\StringHelper;
use App\Models\Post;
use App\User;
use Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Lang;
use Mockery\Exception;

class SendNotificationAboutNewPosts extends Notification
{
    use Queueable;

    /**
     * Пользователь для рассылки email сообщения
     *
     * @var User $user
     */
    private $user;

    /**
     * Посты для рассылки
     *
     * @var Post[]
     */
    private $posts;

    /**
     * Тема email письма
     *
     * @var $subject string
     */
    private $subject;

    /**
     * Колличество прошедших недель, за которые происходит рассылка
     *
     * @var integer $countWeek
     */
    private $countWeek;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param $posts
     * @param $subject
     * @param $countWeek
     */
    public function __construct(User $user, array $posts, string $subject, int $countWeek)
    {
        $this->user = $user;
        $this->posts = $posts;
        $this->subject = $subject;
        $this->countWeek = $countWeek;
    }

    /**
     * Получить заголовки случайных постов
     *
     * @param int $countPosts
     * @return array
     */
    private function getRandomPostsTitle($countPosts = 3)
    {
        $posts = Arr::random($this->posts, $countPosts);
        $postsTitles = [];
        foreach ($posts as $post) {
            /** @var Post $post */
            $postsTitles[] = $post->title;
        }
        return $postsTitles;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->line('Здраствуйте, ' . $this->user->name . '!')
            ->line('За ' . $this->countWeek . ' '
                . Lang::choice('wordsForms.weeksForNotifyMessage', $this->countWeek)
                . ' на сайте '
                . Lang::choice('wordsForms.articlesAppeared', $this->posts) . ' '
                . count($this->posts) .' '
                . Lang::choice('wordsForms.newArticlesForNotifyMessage', $this->posts))
            ->line('Если есть свободное время, то уделите минутку своего времени')
            ->line('Вот лишь некоторые заголовки новых статей - ' . implode(', ', $this->getRandomPostsTitle()))
            ->line('Просмотреть все статьи вы можете на сайте.')
            ->action('Посмотреть статьи', url('/posts'));
    }
}
