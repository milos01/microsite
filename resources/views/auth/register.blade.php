<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Registration</title>
        <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
        <link rel="stylesheet" href="css/custom.css">
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    </head>
    <body>
    <div class="container">
        <div class="registration-form-wrapper">
        <div class="form-logo"><img src="http://www.webueno.com/wp-content/uploads/2016/12/webueno-footer-logo-1.png" alt="webueno-form-logo" /></div>
   
        <h1 class="reg-form-page-title">CREATE YOUR ACCOUNT</h1>

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
                        <div class="reg-form-label">
                            <label>FIRST NAME</label>
                            <span class="reg-form-req-symbol">*</span> 
                        </div>
                        <input id="fullname" type="text" placeholder="" name="first_name" value="{{ old('first_name') }}" required autofocus>
                        <div class="reg-form-field-error">
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="reg-form-field-wrap">
                        <div class="reg-form-label">
                            <label>LAST NAME</label>
                            <span class="reg-form-req-symbol">*</span> 
                        </div>
                        <input id="fullname" type="text" placeholder="" name="last_name" value="{{ old('last_name') }}" required>
                        <div class="reg-form-field-error">
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="reg-form-field-wrap">
                    <div class="reg-form-label">
                        <label>EMAIL</label>
                        <span class="reg-form-req-symbol">*</span>  
                    </div>
                        <input id="email" type="email" placeholder="" name="email" value="{{ old('email') }}" required>
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
                            <label>PHONE</label>
                            <span class="reg-form-req-symbol">*</span>  
                        </div>
                        <input id="email" type="number" placeholder="" name="phone" value="{{ old('phone') }}" required>
                        <div class="reg-form-field-error">
                        @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="reg-form-field-wrap">
                        <div class="reg-form-label">
                            <label>PASSWORD</label>
                            <span class="reg-form-req-symbol">*</span>  
                        </div>
                        <input id="email" type="password" name="password" required>
                        <div class="reg-form-field-error">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="reg-form-field-wrap">
                        <div class="reg-form-label">
                            <label>CONFIRM PASSWORD</label>
                            <span class="reg-form-req-symbol">*</span>  
                        </div>
                        <input id="email" type="password" name="password_confirmation" required>
                        <div class="reg-form-field-error">
                            
                        </div>
                    </div>
               
                    <div class="reg-form-submit-wrap">
                        <button type="submit" target="_blank" type="button" class="reg-form-btn">Register</button>
                    </div>
                </fieldset>
            </form>
        </div> <!-- Registration Form Wrapper ends -->
    </div> <!-- Content ends -->

     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html> 


<!-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">First name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Last name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone number</label>

                            <div class="col-md-6">
                                <input id="phone" type="number" class="form-control" name="phone" value="{{ old('phone') }}" required>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->

