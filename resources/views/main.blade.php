@extends('layouts.app')
@section('title', 'Page Title')
@section('content')
<main class="flex-grow-1">
    <div class="jumbotron jumbotron-fluid">
        <div class="container-lg">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-8 mx-auto">
                    <h1 class="display-3">Page Analyzer</h1>
                    <p class="lead">Check web pages for free</p>
                    <form action="/urls" method="post" class="d-flex justify-content-center">
                        @csrf
                            <input type="text" name="url[name]" value="" class="form-control form-control-lg" placeholder="https://www.example.com">
                        <input type="submit" class="btn btn-lg btn-primary ml-3 px-5 text-uppercase" Value='Check'>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
