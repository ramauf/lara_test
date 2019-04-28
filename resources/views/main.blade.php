<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <script type="text/javascript" src="/js/app.js" rel="stylesheet"></script>
    <script type="text/javascript" src="/js/script.js" rel="stylesheet"></script>
    <link href="/css/app.css" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div id="wrapper">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-xs-10">
                @include($template)
            </div>
            <div class="col-xs-2">
                <h3>Меню</h3>
                <a href="/">Погода в Брянске</a><br />
                <a href="/orders">Заказы</a><br />
                <a href="/products">Товары</a><br />
            </div>
        </div>
    </div>
</div>
</body>
</html>