<?php

namespace App\Console\Commands;

use App\Helpers\StringHelper;
use App\Models\Post;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;
use \App\Notifications\SendNotificationAboutNewPosts;

class SendNotificationAboutNewPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:aboutNewPosts {dateFrom} {dateTo} {subject=Новые статьи на сайте}';

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
     * Дата после которой будут браться статьи для рассылки
     * @var string
     */
    private $dateFrom;

    /**
     * Дата до которой будут браться статьи для рассылки
     * @var string
     */
    private $dateTo;

    /**
     * Количество недель равное разности дат рассылки
     * @var integer $countWeek
     */
    private $countWeek;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->init();

        foreach ($this->getUsers() as $user) {
            $user->notify(new SendNotificationAboutNewPosts(
                $user,
                $this->getPosts(),
                $this->subject,
                $this->getCountWeek()));
        }
        return  true;
    }

    private function init()
    {
        $this->subject = $this->argument('subject');
        $this->dateFrom = $this->argument('dateFrom');
        $this->dateTo = $this->argument('dateTo');
        $this->calculateWeekCount();

        //Выборка постов при помощи scope-метода
        $posts = Post::postsForEmailNotify($this->dateFrom, $this->dateTo)->get('title');

        foreach ($posts as $post) {
            $this->posts[] = $post;
        }

        $users = User::all();
        foreach ($users as $user) {
            $this->users[] = $user;
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
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * Вычисляет и устанавливает количетво недель для дат рассылки
     */
    private function calculateWeekCount(): void
    {
        $dateFrom = Carbon::createFromTimeString($this->dateFrom.' 00:00:00');
        $dateToTimeStamp = Carbon::createFromTimeString($this->dateTo.' 00:00:00');
        $this->setCountWeek($dateToTimeStamp->diffInWeeks($dateFrom));
    }

    /**
     * @return int
     */
    public function getCountWeek(): int
    {
        return $this->countWeek;
    }

    /**
     * Устанавливает количестов недель
     * @param int $countWeek
     */
    public function setCountWeek(int $countWeek) : void
    {
        $this->countWeek = $countWeek;
    }
}
