@php
    $route ='admin.'.$type.'.create';
@endphp

<div class="container">
    <div class="row mt-2 mb-2 adminPage-header">
        <ul class="d-flex">
            <li class="">
                <a href="{{route($route)}}" class="btn btn-success">Создать пост</a>
            </li>
            <li class=""><b>Всего новостей: {{$itemsCount}}</b></li>
        </ul>
    </div>
</div>
