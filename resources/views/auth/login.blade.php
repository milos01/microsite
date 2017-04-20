@extends('layouts.home')
@section('title', 'Login')
@section('navbar')
@stop
@section('contentDashboard')
    <div class="container" id="login-form-container">
    <div class="form-logo">
    <a href="https://micromedic.io/"><img src="img/micromedic-logo.png" alt="webueno-form-logo" /></a>
    </div>
        <div class="login-form-wrapper">
            <h1 class="login-form-page-title">Login</h1>
            <form class="form-horizontal" method="POST" action="{{ url('/login') }}" novalidate>
                {{ csrf_field() }}
                <fieldset>
                <div class="reg-form-field-wrap">
                    
                        <input id="projectname" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                        <div class="reg-form-field-error">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="reg-form-field-wrap">
                        
                        <input type="password" id="password" name="password" placeholder="password" required>
                        <div class="reg-form-field-error">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                <div class="reg-form-submit-wrap">
                    <button type="submit" target="_blank" type="button" class="reg-form-btn">LOGIN</button>
                </div>
                </fieldset>
            </form>
            <a href="{!! route('password.request') !!}" class="forgot-pass-a">Forgot password?</a>
        </div>
        <p class="sign-up-link">Don't have an account? <a href="{!! route('register') !!}">Sign up</a></p>
    </div>
@endsection

