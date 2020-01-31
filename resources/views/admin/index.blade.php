@extends('layout.layout')

@section('content')
    <?php /** @var $message \App\Models\Message */ ?>
    <div class="col-md-9 contacts">
        <h3>Сообщения от пользователей</h3>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Email</th>
                <th scope="col">Сообщение</th>
                <th scope="col">Дата отправки</th>
            </tr>
            </thead>
            <tbody>
            @foreach($messages as $message)
                <tr>
                    <td>{{$message->email}}</td>
                    <td>{{$message->message}}</td>
                    <td>{{$message->created_at->addDecadeWithNoOverflow()}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection