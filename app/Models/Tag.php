<?php

namespace App\Models;

use App\Models\Interfaces\Contentable;
use App\Models\Traits\CacheableTrait;
use Cache;
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\News[] $news
 * @property-read int|null $news_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends Model implements Contentable
{
    use CacheableTrait;

    const CACHE_TAGS = 'tags';

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
     * Установка полиморфной связи с таблицей постов
     *
     * @return BelongsToMany
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    /**
     * Установка полиморфной связи с таблицей новостей
     *
     * @return BelongsToMany
     */
    public function news()
    {
        return $this->morphedByMany(News::class, 'taggable');
    }

    /**
     *
     * Возвращает коллекцию тегов для sidebar, у которых есть опубликованные посты
     * @return Collection
     */
    public static function getTagsCloud()
    {
        $tags = (new static)
            ->whereHas('posts', function ($query) {
                $query
                    ->where('publish', '=', '1');
            })
            ->orHas('news')
            ->get();
        return $tags;
    }
}
