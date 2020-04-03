<?php

namespace App\Console\Commands;

use App\Helpers\StringHelper;
use App\Models\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use \App\Notifications\SendNotificationAboutNewPosts;

class SendNotificationAboutNewPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:aboutNewPosts {countWeek=1} {subject=Новые статьи на сайте}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Отправить всем пользователям рассылку о новых постах на сайте за прошедшую неделю';

    /**
     * Тема отправляемого сообщения
     *
     * @var string $subject
     */
    private $subject;

    /**
     * Посты для рассылки
     *
     * @var Post[] $posts
     */
    private $posts;

    /**
     * @var User[] $users
     */
    private $users;

    /**
     * Количество недель для указания периода, за который нужно будет взять посты для рассылки
     *
     * @var integer $countWeek
     */
    private $countWeek;

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->init();

        foreach ($this->getUsers() as $user) {
            $user->notify(new SendNotificationAboutNewPosts($user, $this->getPosts(), $this->subject, $this->countWeek));
        }
        return 'Уведомления всем пользователям за период в '
            . $this->argument('countWeek')
            . StringHelper::morph($this->argument('countWeek'), 'неделю', 'недели', 'недель')
            . ' успешно отправлены';
    }

    private function init()
    {
        $this->subject = $this->argument('subject');
        $this->countWeek = $this->argument('countWeek');

        $posts = Post::where('created_at', '>=', Carbon::now()->subWeek())->get(['title']);
        foreach ($posts as $post) {
            $this->setPost($post);
        }

        $users = User::all();
        foreach ($users as $user) {
            $this->setUser($user);
        }
    }

    /**
     * @return Post[]
     */
    public function getPosts(): array
    {
        return $this->posts;
    }

    /**
     * @param Post $post
     */
    public function setPost(Post $post): void
    {
        $this->posts[] = $post;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->users[] = $user;
    }
}
