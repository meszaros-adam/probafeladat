<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Próbafeladat!</title>
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

</html>