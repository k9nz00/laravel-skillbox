<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\admin\Feedback
 *
 * @property int $id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Feedback whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Feedback whereFeedbacks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Feedback whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $feedback
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Feedback whereFeedback($value)
 */
class Feedback extends Model
{
   public $guarded = [];
}
