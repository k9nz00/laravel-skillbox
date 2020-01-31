<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Message
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $email
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUpdatedAt($value)
 */
class Message extends Model
{
    public $guarded = [];
}
