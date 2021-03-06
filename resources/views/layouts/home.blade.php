<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>
      @yield('title')
    </title>
    <link rel="icon" type="image/x-icon" href="../img/favicon.png" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../css/custom.css">
    <link rel="stylesheet" href="../bower_components/select2/select2.css">
    <!-- <link rel="stylesheet" href="../bower_components/dropzone/dist/basic.css"> -->
    <link rel="stylesheet" href="../bower_components/dropzone/dist/dropzone.css">
    <!-- <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css"> -->
    <style type="text/css">
      [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
        display: none !important;
      }
    </style>
  </head>
  <body ng-app="micrositeApp">
  <!-- HEADER start -->
    @section('navbar')
    <nav class="navbar navbar-default">
      <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{!! route('home') !!}"><img src="../img/micromedic-logo.png" alt="Webueno Logo"></a>
      </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav main-menu-border">
        <li {{{ (Request::is('home') ? 'class=active' : '') }}}><a href="{!! route('home') !!}">WEBSITES <span class="sr-only">(current)</span></a></li>
        <li {{{ (Request::is('tokens') ? 'class=active' : '') }}}><a href="{!! route('tokens') !!}">TOKENS</a></li>
        <li style="display: none"><a href="#">SUPPORT</a></li>     
      </ul>
      <ul id="dd" class="nav navbar-nav">      
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="../img/account-icon.png" alt="Account icon"></a>
            <ul class="dropdown-menu">
            <li>
            @if(Auth::check())
              <p class="user-name">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</p><p class="user-email">{{Auth::user()->email}}</p>
            @endif
            </li>
              <li role="separator" class="divider"></li>
              <li class="subdrop-mobile"><a href="{!! route('profile') !!}">Settings</a></li>           
              <li class="subdrop-mobile"><a href="{!! route('logout') !!}">Logout</a></li>
            </ul>
         </li>
        </ul>  
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  @show
  <!-- HEADER end -->
  
  @yield('contentDashboard')
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script type="text/javascript" src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="../bower_components/select2/select2.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../bower_components/angular/angular.min.js"></script>
    <script type="text/javascript" src="../bower_components/lodash/lodash.js"></script>
    <script type="text/javascript" src="../bower_components/restangular/dist/restangular.min.js"></script>
    <script type="text/javascript" src="../bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
    <script type="text/javascript" src="../bower_components/angular-ui-select2/src/select2.js"></script>
    <script type="text/javascript" src="../bower_components/dropzone/dist/dropzone.js"></script>
    <!-- <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script> -->



    <script type="text/javascript" src="../js/app.js"></script>
    <script type="text/javascript" src="../js/scripts/user-controller.js"></script>
    <script type="text/javascript" src="../js/scripts/website-controller.js"></script>
    <script type="text/javascript" src="../js/scripts/braintree-controller.js"></script>
    <script type="text/javascript" src="../js/scripts/token-controller.js"></script>
    <script type="text/javascript" src="../js/scripts/user-resource.js"></script>
    <script type="text/javascript" src="../js/scripts/website-resource.js"></script>
    <script type="text/javascript" src="../js/scripts/token-resource.js"></script>

    <script src="https://js.braintreegateway.com/js/braintree-2.30.0.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
  </body>
</html>