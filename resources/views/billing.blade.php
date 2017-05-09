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
      <p class="usage-title">Billing overview</p> 
    </div>      
    <div class="usage-wrapper"> 


      <table class="table">
        <thead>
          <th>Website</th>
          <th>Theme ID</th>
          <th>Domain</th>
          <th>Created</th>
          @if(Auth::user()->subscribed == 1)
          <th>Next payment</th>
          @else
          <th>Expire at</th>
          @endif

          <th>Status</th>
          <th>Monthly Price</th>

        </thead>  
        <tbody>

          @foreach($websites as $website)
          
          <tr>
            <td>{{$website->title}}</td>
            <td>{{$website->theme->theme_id}}</td>
            <td>{{$website->domain}}</td>
            <td>{{$website->created_at->format('m/d/Y')}}</td>
            @if($website->active === 0)
              <td>After you pay</td>
            @else
              @if($website->expire_at)
                <td>{{$website->expire_at->format('m/d/Y')}}</td>
              @else
                <td>{{$website->grace_period->format('m/d/Y')}} (grace period)</td>
              @endif
            @endif
            


            @if($website->user->trial_ends_at)
            <td>Trial</td>
            @else
            @if($website->active === 1)
            <td>Active</td>
            @else 
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
      @if(!Auth::user()->trial_ends_at)
      <hr style="border-top-color: #d8d8d8">
      <span class="pull-left" style="margin-left: 10px"><h4>Outstanding balance: ${{$totalSum}}</h4></span>
      @endif
      @endif
    </div><!-- usage ends -->

    <!-- Automated Payments --> 
    <form method="post" action="{!! route('checkout') !!}" ng-controller="subscriptionController" name="paymentForm"> 
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
      @if(!$nonactivesites->isEmpty() and Auth::user()->trial_ends_at == null)
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
                  <div class="alert alert-danger">
                    {{session('bt_errors')}}
                  </div>
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
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapsePP" style="color:#1c84c6;text-decoration: none"></a>
                          </h4>
                        </div>
                        <div id="collapsePP" class="panel-collapse">
                          <div class="panel-body">
                            <div class="row">

                              <div class="col-md-12">
                            <!-- <div class="form-group col-md-5" id="paymentPart3" ng-class="{ 'has-error' : paymentForm.cardholder.$invalid && !paymentForm.cardholder.$pristine}" style="margin-left: -15px; display: none;">
                                <input type="text" class="form-control" id="new-headline" name="cardholder" ng-model="cardholder" placeholder="Cardhodler name" required />
                              </div> -->

                              {{ csrf_field() }}
                              <div id="dropin-container"></div>

                              <button type="submit" class="btn btn-default" id="paymentPart2" style="margin-top: 20px;display: none">Make payment</button>

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
  <div id="table-row" class="row billing-history-row" ng-controller= "invoiceController">
    <!-- Table Title -->    
    <div class="billing-history-title-wrapper">
      <p class="billing-history-title">Billing History</p> 
    </div>     
    <div class="billing-history-wrapper">  
      @if(Auth::user()->braintree_id)
      <table class="table">

        <thead>
          <th>Date</th>
          <th>Description</th>
          <th>Amount</th>
        </thead>       
        <tbody>
          <tr ng-repeat="invoice in invoices" ng-cloak>
            <td ng-bind="invoice[0]"></td>
            <td ng-bind="invoice[1]"></td>
            <td ng-bind="invoice[2]"></td>
            <td><a class="view-invoice" href="/user/invoice/@{{invoice[3]}}">Download</a></td>
          </tr>
        </tbody> 
      </table>
      <p style="padding-top: 10px;margin-left: 8px" ng-show="showLoadInvoices" ng-cloak>Generating invoices...</p>
      @else
      <p style="padding-top: 10px">No invoices yet!</p>
      @endif
    </div>
  </div>

  <script src="https://js.braintreegateway.com/js/braintree-2.31.0.min.js"></script>
  @endsection
