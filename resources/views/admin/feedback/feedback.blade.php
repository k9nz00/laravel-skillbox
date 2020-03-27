<?php $i= 0; ?>
@extends('layouts.masterLayout')

@section('title', 'Обратная связь')

@section('aside')

@show

@section('content')
    <?php /** @var $message \App\Models\Admin\Feedback */ ?>
    <div class="col-md-12    contacts">
        <h3>Сообщения от пользователей</h3>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">№_</th>
                <th scope="col">Email</th>
                <th scope="col">Сообщение</th>
                <th scope="col">Дата отправки</th>
            </tr>
            </thead>
            <tbody>
            @foreach($messages as $message)
                <tr>
                    <td><b>{{++$i}}</b></td>
                    <td>{{$message->email}}</td>
                    <td>{{$message->feedback}}</td>
                    <td style="width: 100px">{{$message->created_at->locale('ru')->isoFormat('MMMM D YYYY, LT')}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
