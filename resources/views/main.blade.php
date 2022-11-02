@extends('layouts.app')
@section('title', 'Page Title')
@section('content')
<main class="flex-grow-1">
    <div class="jumbotron jumbotron-fluid">
        <div class="container-lg">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-8 mx-auto border rounded-3 bg-light p-5 mt-3">
                    <h1 class="display-3">Анализатор страниц</h1>
                    <p class="lead">Бесплатно проверяйте сайты на SEO пригодность</p>
                    <form action="/urls" method="post" class="row" required>
                        @csrf
                        <div class="col-8">
                            <input
                            type="text"
                            class="form-control form-control-lg @error('url.name') is-invalid @enderror"
                            name="url[name]"
                            placeholder="https://www.example.com"
                            value="{{old('url.name')}}">
                            @error('url.name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <input type="submit" class="btn btn-primary btn-lg ms-3 px-5 text-uppercase mx-3" value="Проверить">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
