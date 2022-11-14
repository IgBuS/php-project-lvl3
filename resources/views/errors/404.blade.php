@extends('layouts.app')
@section('title', 'Page Title')
@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="text-center">
            <h1 class="display-1 fw-bold">404</h1>
            <p class="fs-3"> <span class="text-danger">Opps!</span> Страница не найдена....</p>
            <p class="lead">
                Кажется, страница, которую вы ищите - не существует. Очень жаль(
            </p>
            <a href="{{roure('main')}}" class="btn btn-primary">На главную</a>
        </div>
    </div>
@endsection
