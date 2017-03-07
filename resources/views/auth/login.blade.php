@extends('layouts.home')
@section('title', 'Login')
@section('navbar')
@stop
@section('contentDashboard')
    <div class="container">
        <div class="login-form-wrapper">
            <div class="form-logo"><img src="http://www.webueno.com/wp-content/uploads/2016/12/webueno-footer-logo-1.png" alt="webueno-form-logo" /></div>
            <h1 class="login-form-page-title">LOGIN</h1>
            <form class="form-horizontal" method="POST" action="{{ url('/login') }}" novalidate>
                {{ csrf_field() }}
                <fieldset>
                <div class="reg-form-field-wrap">
                    <div class="reg-form-label">
                       <label>EMAIL</label>
                    </div>
                        <input id="projectname" type="email" name="email" placeholder="" value="{{ old('email') }}" required autofocus>
                        <div class="reg-form-field-error">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="reg-form-field-wrap">
                        <div class="reg-form-label">
                            <label>PASSWORD</label>
                        </div>
                        <input type="password" id="password" name="password" placeholder="" required>
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
        </div>
    </div>
@endsection

