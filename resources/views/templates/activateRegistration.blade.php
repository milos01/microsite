@extends('layouts.home')
@section('title', 'Login')
@section('navbar')
@stop
@section('contentDashboard')
<div class="container" id="registration-form-container">
    <div class="form-logo">
        <a href="https://micromedic.io/"><img src="img/micromedic-logo.png" alt="micromedic-form-logo" /></a>
    </div>
    <div class="registration-form-wrapper">


        <h1 class="reg-form-page-title">THANK YOU FOR JOINING US!</h1>

        <p>Please check your email in order to activate your account.</p>
        <p>Didn't receive URL on your email?<br>Please check your spam folder first.<br>In case email is not there please contact us on:  
            <a href="mailto:support@microsite.com">support@microsite.com</a>   
    </div> 
</div>
@endsection
