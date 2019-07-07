<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/login.css') }}">
</head>
    <body>
        <div class="container">
            <div class="row">
                <div class="box animation flipInX font_size ">
                    <div class="box1">
                        <h3 class="text-primary"><br/>Login to your panel</h3><br/>
                        <!-- Notifications -->
                        <form action="{{ route('login') }}" class="omb_loginForm" autocomplete="off" method="POST">
                            @csrf
                            <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                <label class="sr-only">Email</label>
                                <input type="email" id="email" class="form-control" name="email" placeholder="Email"
                                       value="{!! old('email') !!}">
                                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                            </div>
                            <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                <label class="sr-only">Password</label>
                                <input type="password" id="password" class="form-control" name="password"
                                       placeholder="Password">
                                <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                            </div>
                            <input type="submit" class="btn btn-block btn-primary" value="Log In">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
