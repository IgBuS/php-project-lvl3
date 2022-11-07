@extends('layouts.app')

@section('title', 'Page Title')

@section('content')

<h1 class="mt-3">Сайты</h1>
<div class="table-responsive">
  <table class="table table-bordered table-hover text-nowrap" data-test="urls">
  <tbody>
    <tr>
      <th scope="col">№</th>
      <th scope="col">URL сайта</th>
      <th scope="col">Дата последней проверки</th>
      <th scope="col">Код ответа</th>
      
      
    </tr>


    @foreach ($urls as $url)
    <tr>
      <th scope="row">{{ $url->id }}</th>
        <td>
            <a class="link " href="/urls/{{$url->id}}">{{ $url->name }}</a>
        </td>
        <td>
          @if (array_key_exists($url->id, $latestChecksDates))
          {{ $latestChecksDates[$url->id]}}
          @endif  
          </td>

          <td>
          @if (array_key_exists($url->id, $latestChecksStatuses))
          {{ $latestChecksStatuses[$url->id]}}
          @endif  
          </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
<div class="d-flex align-items-center justify-content-center">{{ $urls->links() }}</div>
@endsection