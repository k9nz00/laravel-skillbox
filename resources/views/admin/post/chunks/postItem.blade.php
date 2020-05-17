@php
    $post = $post ?? new \App\Models\Post();
@endphp
<tr>
    <?php /** @var $post App\Models\Post */ ?>
    <th style="width: 20px">{{$post->id}}</th>
    <td>{{$post->title}}</td>
    <td style="width: 200px;">
        <form method="post"
              action="/admin/postsPanel/publish/{{$post->slug}}">
            @if($post->publish)
                @method('DELETE')
            @else
                @method('PATCH')
            @endif
            @csrf
            <label for="post-{{$post->id}}">
                <button class="btn btn-outline-warning">
                    {{$post->publish ? 'Снять с публикации' : 'Опубликовать'}}
                </button>
            </label>
            <input type="checkbox"
                   class="d-none"
                   name="publish"
                   {{$post->publish ? 'checked' : ''}}
                   onclick="this.form.submit()"
                   id="post-{{$post->id}}">
        </form>
    </td>
    <td style="width: 140px">{{$post->created_at->toDateTimeString()}}</td>
    <td style="width: 350px">
        <a href="{{route('admin.posts.edit', $post->slug)}}" class="btn btn-outline-primary">Редактировать</a>
        @include('admin.post.chunks.deletePost')
    </td>
</tr>
