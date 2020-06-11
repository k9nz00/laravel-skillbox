@php
    $comment = $comment ?? new App\Models\Comment();
@endphp
<div class="comment-item">
    <span class="comment-item-info">{{$comment->created_at->longRelativeDiffForHumans()}}</span>
    <span class="comment-item-info font-weight-bold">{{$comment->owner->name}}</span>
    <span class="comment-item-info">написал:</span>
    <p class="comment-item-body">{{$comment->body}}</p>
</div>
