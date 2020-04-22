<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @method static Builder|\App\Models\Tag newModelQuery()
 * @method static Builder|\App\Models\Tag newQuery()
 * @method static Builder|\App\Models\Tag query()
 * @method static Builder|\App\Models\Tag whereCreatedAt($value)
 * @method static Builder|\App\Models\Tag whereId($value)
 * @method static Builder|\App\Models\Tag whereName($value)
 * @method static Builder|\App\Models\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    /**
     * Защита поля защиненные от массового заполнения
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Ключ для роута
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Установка связи с таблицей постов
     *
     * @return BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     *
     * Возвращает коллекцию тегов для sidebar, у которых есть опубликованные посты
     * @return Collection
     */
    public static function getTagsCloud()
    {
        $tags = (new static)->whereHas('posts', function ($query) {
            $query->where('publish', '=', '1');
        })->get();
        return $tags;
    }
}
