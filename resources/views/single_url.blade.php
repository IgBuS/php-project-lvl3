@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
<div class="container-fluid">
<p>Url's id: {{ $url->id }}</p>
<p>Url's name: {{ $url->name }}</p>
<p>Url's creation date and time {{ $url->created_at }}</p>
<p>Url's update date and time {{ $url->updated_at }}</p>
</div>
@endsection