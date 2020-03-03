@extends('layouts.masterLayout')

@section('navBar')
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
            <a class="navbar-brand" href="{{route('home')}}">
                <img src="{{asset('img/logo.svg')}}" alt="logo">
            </a>
            <div class="register-action">
                @if(url()->current() == route('register'))
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}">Войти</a>
                @elseif(url()->current() == route('login'))
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('register') }}">Зарегистрироваться</a>
                @else
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}">Войти</a>
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('register') }}">Зарегистрироваться</a>
                @endif
            </div>
        </nav>
    </div>

@endsection

@section('aside')
@endsection