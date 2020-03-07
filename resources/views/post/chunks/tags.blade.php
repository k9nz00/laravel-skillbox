@php
    $tags = $tags ?? collect();
@endphp

@if($tags->isNotEmpty())
    <div class="">
        @foreach($tags as $tag)
            <?php /** @var $tag App\Models\Tag */?>
            <a href="{{route('tags.list', $tag->name)}}" class="badge badge-info">{{$tag->name}}</a>
        @endforeach
    </div>
@endif