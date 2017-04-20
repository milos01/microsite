@extends('layouts.home')
@section('title', 'Register')
@section('navbar')
@stop
@section('contentDashboard')
    <div class="container" id="registration-form-container">
    <div class="form-logo">
    <a href="https://micromedic.io/"><img src="img/micromedic-logo.png" alt="webueno-form-logo" /></a>
    </div>
        <div class="registration-form-wrapper">
       
   
        <h1 class="reg-form-page-title">Create your account</h1>

        <form class="form-horizontal" method="POST" action="{{ url('/register') }}" novalidate>
                {{ csrf_field() }}
                <fieldset>
                    <!-- <div class="reg-form-field-wrap">
                        <div class="reg-form-label">
                            <label>COMPANY NAME</label>
                            <span class="reg-form-req-symbol">*</span> 
                        </div>
                        <input type="text" id="companyname" name="companyname" placeholder="">
                        <div class="reg-form-field-error"></div>
                    </div> -->
                    <div class="reg-form-field-wrap">
                     <!-- <div class="reg-form-label">
                            <label>FIRST NAME</label>
                            <span class="reg-form-req-symbol">*</span> 
                        </div> -->
                        <input id="fullname" type="text" placeholder="First name" name="first_name" value="{{ old('first_name') }}" required autofocus>
                        <div class="reg-form-field-error">
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="reg-form-field-wrap">
                       <!-- <div class="reg-form-label">
                            <label>LAST NAME</label>
                            <span class="reg-form-req-symbol">*</span> 
                        </div> -->
                        <input id="fullname" type="text" placeholder="Last name" name="last_name" value="{{ old('last_name') }}" required>
                        <div class="reg-form-field-error">
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="reg-form-field-wrap">
                   <!-- <div class="reg-form-label">
                        <label>EMAIL</label>
                        <span class="reg-form-req-symbol">*</span>  
                    </div> -->
                        <input id="email" type="email" placeholder="Email" name="email" value="{{ old('email') }}" required>
                        <div class="reg-form-field-error">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="reg-form-field-wrap">
                       <!-- <div class="reg-form-label">
                            <label>PHONE</label>
                            <span class="reg-form-req-symbol">*</span>  
                        </div> -->
                        <input id="email" type="number" placeholder="Phone" name="phone" value="{{ old('phone') }}" required>
                        <div class="reg-form-field-error">
                        @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="reg-form-field-wrap">
                       <!-- <div class="reg-form-label">
                            <label>PASSWORD</label>
                            <span class="reg-form-req-symbol">*</span>  
                        </div> -->
                        <input id="email" type="password" name="password" placeholder="Password" required>
                        <div class="reg-form-field-error">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="reg-form-field-wrap">
                       <!-- <div class="reg-form-label">
                            <label>CONFIRM PASSWORD</label>
                            <span class="reg-form-req-symbol">*</span>  
                        </div> -->
                        <input id="email" type="password" name="password_confirmation" placeholder="Confirm password"required>
                        <div class="reg-form-field-error">
                            
                        </div>
                    </div>
               
                    <div class="reg-form-submit-wrap">
                        <button type="submit" target="_blank" type="button" class="reg-form-btn">Register</button>
                    </div>
                </fieldset>
            </form>
        </div> 
    </div>
@endsection
