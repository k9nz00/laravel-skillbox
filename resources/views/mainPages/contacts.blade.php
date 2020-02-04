@extends('layout.layout')

@section('title', 'Контакты')
@section('content')
    <div class="col-md-9 contacts">
        <h2 class="alert alert-info">Добро пожаловать на этот учебный сайт.</h2>
        <p>Выможете связаться или найти нас при помощи контактов указанных ниже! </p>
        <ul class="list-group">
            <li class="list-group-item">Email - (указать)</li>
            <li class="list-group-item">Phone - (указать)</li>
            <li class="list-group-item">Address - (указать)</li>
        </ul>
        <p>Свои вопросы вы можете задать нам, заполнив эту форму обратной связи</p>
        <p>Для возможности связаться с вами помимо своего вопроса, оставте также и свой адрес электронной почты</p>

        <hr>
        <h3>Форма обратной связи</h3>
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label for="inputEmail">Ваша электронная почта</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       id="inputEmail"
                       placeholder="Почта"
                       required>
            </div>
            <div class="form-group">
                <label for="inputMessage">Ваш вопрос или пожелание</label>
                <textarea
                        class="form-control"
                        id="inputMessage"
                        name="feedback"
                        required
                        rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Отправить форму</button>
        </form>
        <hr>
    </div>
@endsection