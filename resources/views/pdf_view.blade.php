<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF Demo in Laravel 7</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  </head>
  <body>
    <table class="table table-bordered">
    <thead>
      <tr class="table-danger">
        <td>Hola</td>
      </tr>
      </thead>
      <tbody>
        @foreach ($comportamientos as $data)
        <tr>
            <td>{{ $data->id }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>

