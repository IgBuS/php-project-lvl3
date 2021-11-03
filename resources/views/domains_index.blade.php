<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Domains</title>
  </head>
  <body>
    <h1>Domains</h1>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">№</th>
      <th scope="col">Domain name</th>
      <th scope="col">Created at</th>
      <th scope="col">Updated at</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($domains as $domain)
    <tr>
      <th scope="row">{{ $domain->id }}</th>
      <td>{{ $domain->name }}</td>
      <td>{{ $domain->created_at }}</td>
      <td>{{ $domain->updated_at }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
  </body>
</html>