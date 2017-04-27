@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 reset-wrapper">
        <div class="form-logo">
    <a href="https://micromedic.io/"><img src="https://micromedic.io/wp-content/uploads/2017/04/micromedic-logo.png" alt="webueno-form-logo"></a>
        </div>
            <div class="panel panel-default reset-panel">
                <div class="panel-heading"><h1 class="reset-title">Reset Password</h1></div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control reset-input" name="email" value="{{ old('email') }}" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 reset-btn-wrapper">
                                <button type="submit" class="btn btn-primary" id="reset-pw-btn">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
