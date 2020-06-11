<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PostHistory
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string|null $before
 * @property string|null $after
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post $post
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostHistory whereAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostHistory whereBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostHistory wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostHistory whereUserId($value)
 * @mixin \Eloquent
 */
class PostHistory extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
