@extends('layouts.app')

@section('content')
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="logo-form">
                    <img src="{{ asset('/img/logo_supervision.png') }}">
                </div>
                <span class="login100-form-title p-b-43">
                    Acceso al Sistema
                </span>
                <div class="wrap-input100 validate-input" data-validate = "Debe ingresar los datos del usuario">
                    <input class="input100" type="text" name="tusNickName" required autofocus>
                    <span class="focus-input100"></span>
                    <span class="label-input100">Usuario</span>
                </div>
                <div class="wrap-input100 validate-input" data-validate="Debe ingresar su contraseña">
                    <input class="input100" type="password" name="password" required>
                    <span class="focus-input100"></span>
                    <span class="label-input100">Contraseña</span>
                </div>
                <div class="flex-sb-m w-full p-t-3 p-b-32">
                    @if ($errors->has('tusNickName'))
                        <span class="form-group{{ $errors->has('tusNickName') ? ' has-error' : '' }}">
                            <strong>El usuario y/o contraseña ingresado son incorrectos</strong>
                        </span>
                    @endif
                    @if ($errors->has('password'))
                        <span class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <strong>La contraseña ingresada es incorrecta</strong>
                        </span>
                    @endif
                    <div>
                        <a href="#" class="txt1">
                            ¿Olvidó su contraseña?
                        </a>
                    </div>
                </div>
                <div class="container-login100-form-btn">
                    <button type="submit" class="login100-form-btn">
                        Ingresar
                    </button>
                </div>
                <div class="text-center p-t-46 p-b-20">
                    <span class="txt2">
                        PUNO - 2018
                    </span>
                </div>

                <div class="login100-form-social flex-c-m">
                    <a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">
                        <i class="fa fa-facebook-f" aria-hidden="true"></i>
                    </a>

                    <a href="#" class="login100-form-social-item flex-c-m bg2 m-r-5">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </a>
                </div>
            </form>
            <div class="login100-more" style="background-image: url('img/gore_sede.jpg');">
            </div>
        </div>
    </div>
</div>
@endsection
