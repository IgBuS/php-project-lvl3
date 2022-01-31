@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
  <table class="table">
  <thead>
    <tr>
      <th scope="col">№</th>
      <th scope="col">Domain name</th>
      <th scope="col">Created at</th>
      <th scope="col">Updated at</th>
      <th scope="col">Дата последней проверки</th>
      
      
    </tr>
  </thead>
  <tbody>
    @foreach ($urls as $url)
    <tr>
      <th scope="row">{{ $url->id }}</th>
        <td>
            <a class="nav-link " href="/urls/{{$url->id}}">{{ $url->name }}</a>
        </td>
      <td>{{ $url->created_at }}</td>
      <td>{{ $url->updated_at }}</td>
      <td>{{ $url->last_check_created_at }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection