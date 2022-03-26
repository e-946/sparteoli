<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Spartteoli</title>
    <link rel="shortcut icon" href="{{asset('img/insignia.png')}}" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: lightgrey;
            color: darkred;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-around {
            align-items: center;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 5em;
        }

        .links > a {
            color: #FFF;
            background-color: darkred;
            border-radius: 10px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            padding: 20px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .links > a:hover {
            color: darkred;
            background-color: #FFF;
            border-radius: 10px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
        }

        .m-b-md {
            margin-bottom: 30px;
            padding: 20px;
        }

        .left img {
            height: 50vh;
        }

        @media (max-width: 800px) {
            .right {
                flex-basis: 100%;
                margin: 0;
            }
            .left {
                flex-basis: 100%;
                margin: 0;
            }
            .m-b-md {
                margin-bottom: 30px;
            }

            .left img {
                height: 25vh;
            }
            .links > a {
                padding: 15px;
            }
            .title {
                font-size: 3em;
                margin: 0;
            }
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content flex-around">
        <div class="m-b-md left">
            <img src="{{ asset('img/logo-brasao.png') }}" alt="Insignia do 9º corpo de bombeiros">
        </div>
        <div class="right">
        @if (Route::has('login'))
            <div class="title m-b-md">
                Sparteoli
            </div>
            <div class="links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
            </div>
        @endif
        </div>
    </div>
</div>
</body>
</html>
