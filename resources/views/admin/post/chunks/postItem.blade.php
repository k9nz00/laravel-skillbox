@php
    $post = $post ?? collect();
@endphp
<tr>
    <?php /** @var $post App\Models\Post */ ?>
    <th scope="row">{{$postNumber}}</th>
    <td>{{$post->title}}</td>
    <td>
        <form method="post"
              action="/admin/postsPanel/publish/{{$post->slug}}">
            @if($post->publish)
                @method('DELETE')
            @else
                @method('PATCH')
            @endif
            @csrf
            <label for="post-{{$post->id}}" class=" w-100">
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
    <td>{{$post->created_at->toDateTimeString()}}</td>
    <td>
        <a href="{{route('admin.posts.edit', $post->slug)}}" class="btn btn-outline-primary">Редактировать</a>
        @include('admin.post.chunks.deletePost')
    </td>
</tr>
