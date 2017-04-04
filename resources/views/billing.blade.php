@extends('layouts.home')

@section('contentDashboard')
 <!-- CONTENT -->   
  <div class="container">
    <div class="page-header"><h1>BILLING</h1></div>
    <!-- Sidebar -->
    <div class="col-sm-2 sidebar">
      <ul>
        <li><a href="{!! route('profile') !!}">PROFILE</a></li>
        @if(Auth::user()->hasRole('admin'))
        <li><a href="{!! route('admin') !!}">ADMIN PANEL</a></li>
        @endif
        <li>BILLING</li>
        <li><a href="{!! route('new') !!}"><button type="button" class="btn btn-default add-website"><span class="plus">+</span>ADD WEBSITE</button></a></li>
      </ul>
    </div>
  <!--  <div id="table-row" class="row">  
        
        </div> -->
    <!-- tabs -->
    <div class="col-sm-10 ">
      <!-- Errors -->
      
      <!-- Usage -->    
      <div id="table-row" class="row">   
      <!-- Table Title -->
      <div class="usage-title-wrapper">
        <p class="usage-title">Usage</p> 
      </div>      
        <div class="usage-wrapper"> 

        
          <table class="table">
            <thead>
              <th>Website</th>
              <th>Theme ID</th>
              <th>Domain</th>
              <th>Created</th>
              <th>Next payment</th>
              <th>Status</th>
              <th>Monthly Price</th>
              
            </thead>  
            <tbody>

              @foreach($websites as $website)
          
              <tr>
                <td>{{$website->title}}</td>
                <td>{{$website->theme->theme_id}}</td>
                <td>{{$website->domain}}</td>
                <td>@dateformat($website->created_at)</td>
                <td>@dateformat($website->expire_at)</td>

                @if($website->user->trial_ends_at)
                    <td>Trial</td>
                @else
                  @if($website->active === 1)
                    <td>Active</td>
                  @else if 
                   <td>Not active</td>
                  @endif
                @endif
                <td>
                @if($website->active === 1)
                  $0.00
                @else
                  ${{$website->theme->price}}
                @endif
                </td>
              </tr>
               @endforeach
            </tbody> 

          </table>
          @if($websites->isEmpty())
          <div class="col-md-12" style="text-align: center;padding: 20px 0px;background: #efeded">
            <span style="color: black">No new websites!</span>
          </div>
          @else
          <hr style="border-top-color: #d8d8d8">
          <span class="pull-left" style="margin-left: 10px"><h4>total: ${{$totalSum}}</h4></span>
          @endif
        </div><!-- usage ends -->

      <!-- Automated Payments --> 
      <form method="post" action="{!! route('checkout') !!}" ng-controller="subscriptionController"> 
      @if(!$activeWebsites->isEmpty()) 
      <div id="table-row" class="row automated-payment-row">   
      <!-- Table Title -->      
      <div class="automated-payment-title-wrapper">
        <p class="automated-payment-title">Automated Payments</p> 
      </div>
        <div class="automated-payment-wrapper" >   
          <p class="automated-payment-text">I don’t want to make payments manually every month. Please charge me automatically.</p>      
          <!-- <div class="yes-no-slider-wrapper"> -->
            <!-- <div class="yes-no-slider"></div> -->
            <div class="pull-right" style="margin-top: 10px">
              <input type="radio" name="subscribed" ng-model="subscribed" value="yes" ng-checked="{{Auth::user()->subscribed}} == 1"> yes
              <input type="radio" name="subscribed" ng-model="subscribed" value="no" ng-checked="{{Auth::user()->subscribed}} == 0"> no
            </div>
          <!-- </div> -->
        </div>
      </div><!-- Automated Payments ends -->
      @endif
      
      <div ng-show="oneTimer" ng-cloak>   
        <div id="table-row" class="row automated-payment-row">  
          <div class="automated-payment-title-wrapper">
            <p class="automated-payment-title">Active sites</p> 
          </div>
          <div class="automated-payment-wrapper" >  
            <table class="table">
              <thead>
                <th>Domain</th>
               <!--  <th>Theme ID</th>
                <th>Domain</th>
                <th>Created</th>
                <th>Next payment</th>
                <th>Status</th>
                <th>Monthly Price</th> -->
                
              </thead>  
              <tbody>
                @foreach($activeWebsites as $website)
                <tr>
                  <td>{{$website->title}}</td>
                </tr>
                 @endforeach
              </tbody> 
            </table>
        
          </div>
        </div>
      </div>
      <!-- Billing Alerts -->   
      <!-- <div id="table-row" class="row billing-alerts-row">  -->
      <!-- Table Title -->    
      <!-- <div class="billing-alerts-title-wrapper">
        <p class="billing-alerts-title">Billing Alerts</p> 
      </div>    
        <div class="billing-alerts-wrapper">   
          <p class="billing-alerts-text">Send me an email notifications anytime my credit card expires.</p>      
          <div class="yes-no-slider-wrapper">
            <div class="yes-no-slider"></div>
            <p class="yes">YES</p>
            <p class="no">NO</p>
          </div>
        </div>
      </div> --><!-- Billing Alerts ends -->

      <!-- Payment Method -->
      @if(!$websites->isEmpty() and Auth::user()->trial_ends_at == null)
      <div id="table-row" class="row payment-method-row">
      <!-- Table Title -->   
      <div class="payment-method-title-wrapper">
        <p class="payment-method-title">Payment Method</p> 
      </div>
        <div class="payment-method-wrapper">  
          <ul class="nav nav-tabs">
             <div class="wrapper wrapper-content animated fadeInRight" ng-controller="braintreeController">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                        @if (session('bt_errors'))
                          @foreach(session('bt_errors') as $error)
                            <div class="alert alert-danger">
                                 {{$error->message}}
                            </div>
                            @endforeach
                        @endif
                        @if (Auth::user()->card_last_four == null)
                            <div class="ibox-content">
                                <div class="panel-group payments-method" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background: white">
                                        <h2>Summary</h2>
                                            <strong>Price:</strong> <span class="text-navy">${{$totalSum}}</span>

                                                        <p class="m-t">
                                                            
                                                            Please enter your preferred payment method below. You can use a credit card or prepay through PayPal. 

                                                        </p>
                                            <h4 class="panel-title" style="margin-top: 20px">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapsePP" style="color:#1c84c6;text-decoration: none">Choose method</a>
                                            </h4>
                                        </div>
                                        <div id="collapsePP" class="panel-collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        
                                                              {{ csrf_field() }}
                                                              <div id="dropin-container"></div>
                                                              
                                                              <button type="submit" class="btn btn-default" id="paymentButt" style="margin-top: 20px;display: none">Make payment</button>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="panel-heading" style="background: white">
                              <h2>Pay with same card <h3>{{Auth::user()->card_brand}}: **** **** **** {{Auth::user()->card_last_four}}</h3></h2>
                              
                              <a href="{!! route('samecardPayment') !!}" type="button" class="btn btn-default" ng-click="clickPayButt()" style="margin-top: 30px">Make payment 
                              <i ng-show="showSpin"  class="fa fa-spinner fa-spin fa-fw" ng-cloak></i>
                              <span class="sr-only">Loading...</span></a>
                              <a href="{!! route('removePayment') !!}" type="button" class="btn btn-danger" style="margin-top: 30px">Remove this card</a>
                            </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
          </ul>  
        </div>  
      </div>
      @endif 
      </form> 
      <!-- Billing History -->    
      @if($invoices) 
      <div id="table-row" class="row billing-history-row">
      <!-- Table Title -->    
      <div class="billing-history-title-wrapper">
        <p class="billing-history-title">Billing History</p> 
      </div>     
        <div class="billing-history-wrapper">  
          <table class="table">
                
            <thead>
              <th>Date</th>
              <th>Description</th>
              <th>Amount</th>
            </thead>       
            <tbody>

            @foreach($invoices as $invoice)

              <tr>
                <td>{{$invoice->date()->toFormattedDateString()}}</td>
                <td>{{$invoice->invliceStatus()}}</td>
                <td>{{$invoice->total() }}</td>
                <td><a class="view-invoice" href="">Download</a></td>
              </tr>
            @endforeach
            </tbody> 
          </table>
        </div>
        </div>
        @endif
        <script src="https://js.braintreegateway.com/js/braintree-2.31.0.min.js"></script>
@endsection
