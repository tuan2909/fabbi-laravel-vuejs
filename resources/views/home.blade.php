<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel-Vuejs</title>
</head>
<body>
<div class="content" style="margin: 0 auto" id="app">
    <div class="title m-b-md">
        Laravel
    </div>
    <example-component :users="{{$users}}" :user="{{$user}}"></example-component>

</div>
</body>
<script src="js/app.js"></script>
</html>
