<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }

        .sign-in {
            height: 100%;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="text-center sign-in">
    @auth('admin')
        登录了
    @endauth
    <form class="form-signin" action="{{ route('login') }}" method="POST">
        <img class="mb-4"
             src="https://camo.githubusercontent.com/0328e86af8b347884b991267d407322be7bc943c/68747470733a2f2f7777772e6d696e69766f74652e636e2f73746f726167652f696d616765732f6d696e6970726f6772616d322e6a706567"
             alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">请登录</h1>
        <div class="form-group">
            {{ csrf_field() }}
            <label for="inputEmail" class="sr-only">邮箱地址</label>
            <input type="email" id="inputEmail" name="email" value="{{ old('email') }}" class="form-control @if ($errors->has('email')) is-invalid @endif" placeholder="邮箱地址" required="" autofocus="">
            @if ($errors->has('email'))
                <div class="invalid-feedback text-left">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputPassword" class="sr-only">密码</label>
            <input type="password" id="inputPassword" name="password" class="form-control @if ($errors->has('password')) is-invalid @endif" placeholder="密码" required="">
            @if ($errors->has('password'))
                <div class="invalid-feedback text-left">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
        <p class="mt-5 mb-3 text-muted">© 2017-2018</p>
    </form>
</div>

</body>
</html>
