<?php

namespace App;

use App\Models\Post;
use Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|\App\User newModelQuery()
 * @method static Builder|\App\User newQuery()
 * @method static Builder|\App\User query()
 * @method static Builder|\App\User whereCreatedAt($value)
 * @method static Builder|\App\User whereEmail($value)
 * @method static Builder|\App\User whereEmailVerifiedAt($value)
 * @method static Builder|\App\User whereId($value)
 * @method static Builder|\App\User whereName($value)
 * @method static Builder|\App\User wherePassword($value)
 * @method static Builder|\App\User whereRememberToken($value)
 * @method static Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Проверка на админские права.
     * Пока как заглушка пользователь с id=1 считается администратором
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->id == 1 ? true : false;
    }

    /**
     * Получить пользователя правами администраторов
     * Пока будет возвращен один пользователь с id =1 .
     * Позже переделать с использованием привелегий
     * @return User
     */
    public static function getAdmin()
    {
        return User::findOrFail(1);
    }

    /**
     * Посты пользователя
     * @return HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'owner_id');
    }
}
