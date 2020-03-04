<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $shortDescription
 * @property int $publish
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePublish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereShortDescription($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property int $owner_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereOwnerId($value)
 * @property-read \App\User $users
 * @property-read \App\User $user
 */
class Post extends Model
{
    /**
     * Поля защищенные от массовой записи
     *
     * @var array
     */
    public $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Установка связи с таблицей тегов
     *
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Проверка на наличие прав для редактирования статьи
     * @param User $user
     * @return bool
     */
    public function isAccessToEdit(?User $user)
    {
        $access = false;
        if (isset($user)){
            if ($this->owner_id == $user->id || $user->isAdmin()) {
                $access = true;
            }
        }

        return $access;
    }
}
