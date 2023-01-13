<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Próbafeladat!</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div id="app">
        @if(Auth::check())
        <app :user="{{Auth::user()}}"></app>
        @else
        <app :user="false"></app>
        @endif
    </div>
    @vite('resources/js/app.js')
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</html>