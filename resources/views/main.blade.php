<!DOCTYPE html>
<html>
    <body class="d-flex flex-column">
        <header>
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <a class="navbar-brand" href="https://pacific-temple-99321.herokuapp.com">Analyzer</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="https://pacific-temple-99321.herokuapp.com">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="https://pacific-temple-99321.herokuapp.com/domains">Domains</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <main class="flex-grow-1">
                            <div class="jumbotron jumbotron-fluid bg-dark">
        <div class="container-lg">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-8 mx-auto text-white">
                    <h1 class="display-3">Page Analyzer</h1>
                    <p class="lead">Check web pages for free</p>
                    <form action="https://pacific-temple-99321.herokuapp.com/domains" method="post" class="d-flex justify-content-center">
                        @csrf
                            <input type="text" name="domain[name]" value="" class="form-control form-control-lg" placeholder="https://www.example.com">
                        <button type="submit" class="btn btn-lg btn-primary ml-3 px-5 text-uppercase">Check</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        </main>

        <footer class="border-top py-3 mt-5">
            <div class="container-lg">
                <div class="text-center">
                    created by
                    <a href="https://hexlet.io/pages/about" target="_blank">Hexlet</a>
                </div>
            </div>
        </footer>
    </body>
</html>
