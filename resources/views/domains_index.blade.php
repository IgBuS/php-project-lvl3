@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
  <table class="table">
  <thead>
    <tr>
      <th scope="col">№</th>
      <th scope="col">URL сайта</th>
      <th scope="col">Запись создана</th>
      <th scope="col">Запись обновлена</th>
      <th scope="col">Дата последней проверки</th>
      
      
    </tr>
  </thead>
  <tbody>
    @foreach ($urls as $url)
    <tr>
      <th scope="row">{{ $url->id }}</th>
        <td>
            <a class="link " href="/urls/{{$url->id}}">{{ $url->name }}</a>
        </td>
      <td>{{ $url->created_at }}</td>
      <td>{{ $url->updated_at }}</td>
      <td>
          @if (array_key_exists($url->id, $latestChecks))
            {{ $latestChecks[$url->id]}}
          @endif  
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $urls->links() }}
@endsection