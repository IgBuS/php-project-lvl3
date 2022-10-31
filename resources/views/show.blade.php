@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
<h1 class="display-3">Сайт: {{ $url->name }}</h1>
<table class="table">

  <tbody>
    <tr>
      <td>ID</td>
      <td>{{ $url->id }}</td>
    </tr>
    <tr>
      <td>Имя</td>
      <td>{{ $url->name }}</td>
    </tr>
    <tr>
      <td>Дата создания</td>
      <td>{{ $url->updated_at }}</td>
    </tr>
  </tbody>
</table>
<form action="/urls/{{ $url->id }}/checks" method="post" class="d-flex justify-content-center">
@csrf
    <input type="submit" class="btn btn-lg btn-primary ml-3 px-5 text-uppercase" value='Запустить проверку'>
</form>

<h1 class="display-3">Проверки</h1>

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Код ответа</th>
      <th scope="col">h1</th>
      <th scope="col">Заголовок</th>
      <th scope="col">Описание</th>
      <th scope="col">Дата создания</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($checks as $check)
    <tr>
      <td>{{ $check->id }}</td>
      <td>{{ $check->status_code }}</td>
      <td>{{ $check->h1 }}</td>
      <td>{{ $check->title }}</td>
      <td>{{ $check->description }}</td>
      <td>{{ $check->created_at }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection