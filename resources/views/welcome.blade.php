<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>votingNow</title>

        <!-- Fonts -->
        {{--<link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
                color: #f35626;
                background-image: -webkit-linear-gradient(92deg,#f35626,#feab3a);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                -webkit-animation: hue 30s infinite linear;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .qrcode {
                margin-top: 30px;
            }

            @-webkit-keyframes hue {
                from {
                    -webkit-filter: hue-rotate(0deg);
                }

                to {
                    -webkit-filter: hue-rotate(-360deg);
                }
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            {{--<div class="top-right links">--}}
                {{--<a href="{{ url('/') }}">Home</a>--}}
                {{--<a href="{{ url('/') }}">Login</a>--}}
                {{--<a href="{{ url('/') }}">Register</a>--}}
            {{--</div>--}}

            <div class="content">
                <div class="title m-b-md">
                    Minivote
                </div>
                <div class="links">
                    小程序
                </div>
                <img width="300" class="qrcode" src="https://www.minivote.cn/storage/images/miniprogram2.jpeg" alt="">
            </div>
        </div>
    </body>
    {{--<script src="{{ asset('js/app.js') }}"></script>--}}
</html>
