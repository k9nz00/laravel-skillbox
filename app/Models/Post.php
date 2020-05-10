<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use DateTime;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;


/**
 * App\Models\Post
 *
 * @property int $id
 * @property int $owner_id
 * @property string $slug
 * @property string $title
 * @property string $shortDescription
 * @property string $body
 * @property int $publish
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post getLastPublishedArticles()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post postsForEmailNotify($dateFrom, $dateTo)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePublish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @mixin \Eloquent
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
     * Установка полиморфной связи с таблицей тегов
     *
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Установка связи с таблицей пользователей.
     * Позволяет получить создателя статьи
     *
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Публикация статьи
     *
     * @param bool $publish
     */
    public function published($publish = true)
    {
        $this->update([
            'publish' => $publish,
        ]);
    }

    /**
     * Снятие статьи с пубикации
     */
    public function anPublished()
    {
        $this->published(false);
    }

    /**
     * Получить посты для рассыки, попадающие в интервал дат создания
     *
     * @param $query
     * @param string $dateFrom
     * @param string $dateTo
     * @return Collection
     */
    public function scopePostsForEmailNotify($query, string $dateFrom, string $dateTo)
    {
        return $query->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 00:00:00']);
    }

    /**
     * Получить все опубликованные посты с тегами, которые к ним привязаны
     *
     * @param int $postLimit
     * @return Builder[]|Collection
     */
    public static function getLastPublishedArticlesWithTags(int $postLimit = 30)
    {
        return static::getLastPublishedArticles()
            ->limit($postLimit)
            ->with([
                'tags' => function ($query) {
                    $query->select('name');
                },
            ])
            ->get(['id', 'title', 'slug', 'shortDescription', 'created_at']);
    }

    /**
     * Получить все опубликованные посты отфильтрованные по дате создания в обратном порядке
     *
     * @return Builder
     */
    public function scopeGetLastPublishedArticles()
    {
        return static::wherePublish(1)->latest();
    }
}
