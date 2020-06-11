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
                    <a class="nav-link" href="{{route('posts.index')}}">Все статьи</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('posts.create')}}">Создать статью</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('news.index') }}">Все новости</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('about')}}">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('contacts')}}">Контакты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('statistic')}}">Статистика</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin')}}">Админ. раздел</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/telescope">Telescope</a>
                </li>
            </ul>
        </div>

        @guest
            <div class="register-action">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}">Войти</a>
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('register') }}">Зарегистрироваться</a>
            </div>
        @else
            <div class="user-menu">
                <a id="navbarDropdown" class="btn btn-sm btn-outline-secondary dropdown-toggle" href="#"
                   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        Выйти
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        @endguest
    </nav>
</div>
