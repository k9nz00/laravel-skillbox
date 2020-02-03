<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{route('home')}}">
            <img src="{{asset('img/logo.svg')}}" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto text-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home')}}">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('about')}}">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('contacts')}}">Контакты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('post.create')}}">Создать статью</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin')}}">Админ. раздел</a>
                </li>
            </ul>
        </div>
    </nav>
</div>