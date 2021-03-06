<?php /** @var $post App\Models\Post */ ?>

    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container">
    <h1>Сформированный отчет "Итого"</h1>
    <p>
        По вашему запросу был сформироваан и отправлен на почту отчет с подсчетом количества разлиных сущностей на сайте.
        Ниже представлен сформированный отсчет в теле этого сообщения.
        Также к письму должен быть приложен этот отчет в виде Exel.
    </p>
    <div class="">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Наименование</th>
                <th scope="col">Количество</th>
            </tr>
            </thead>
            <tbody>
            @foreach($instances as $instance)
                <tr>
                    <th>{{$instance[0]}}</th>
                    <td>{{$instance[1]}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    С уважением,<br>
    {{ config('app.name') }}
</div>
</body>
</html>






