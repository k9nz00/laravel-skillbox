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
 * @property string $title
 * @property string $body
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|\App\Models\Post newModelQuery()
 * @method static Builder|\App\Models\Post newQuery()
 * @method static Builder|\App\Models\Post query()
 * @method static Builder|\App\Models\Post whereBody($value)
 * @method static Builder|\App\Models\Post whereCreatedAt($value)
 * @method static Builder|\App\Models\Post whereId($value)
 * @method static Builder|\App\Models\Post whereSlug($value)
 * @method static Builder|\App\Models\Post whereTitle($value)
 * @method static Builder|\App\Models\Post whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $shortDescription
 * @property int $publish
 * @method static Builder|\App\Models\Post wherePublish($value)
 * @method static Builder|\App\Models\Post whereShortDescription($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property int $owner_id
 * @method static Builder|\App\Models\Post whereOwnerId($value)
 * @property-read \App\User $users
 * @property-read \App\User $user
 * @property-read \App\User $owner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post postsForEmailNotify($dateFrom, $dateTo)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post getLastPublishedArticles()
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
        return $query
            ->where('created_at', '>=', $dateFrom . ' 00:00:00')
            ->where('created_at', '<=', $dateTo . ' 00:00:00');
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
