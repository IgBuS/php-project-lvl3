@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
<h1 class="mt-3">Сайт: {{ $url->name }}</h1>
<div class="table-responsive">
<table class="table table-bordered table-hover text-nowrap" data-test="url">

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
</div>
<h2 class="mb-3 mt-5">Проверки</h2>

<form action="/urls/{{ $url->id }}/checks" method="post" class="d-flex justify-content-left mb-3">
@csrf
    <input type="submit" class="btn btn-primary" value='Запустить проверку'>
</form>

<div class="table-responsive">
<table class="table table-bordered table-hover text-nowrap" data-test="checks">
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
</div>
<div class="d-flex align-items-center justify-content-center">{{ $checks->links() }}<div>
@endsection